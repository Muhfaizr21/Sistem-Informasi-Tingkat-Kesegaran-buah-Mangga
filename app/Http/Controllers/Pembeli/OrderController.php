<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\ImageHelper;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $pembeli = Auth::user()->pembeli;
        
        if (!$pembeli) {
            return view('pembeli.pesanan.index', ['pesanans' => collect()]);
        }

        $query = Pesanan::with(['items.listing'])
            ->where('pembeli_id', $pembeli->id);

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Payment Method
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        $pesanans = $query->latest()->paginate(10);

        return view('pembeli.pesanan.index', compact('pesanans'));
    }

    public function show($id)
    {
        $pembeli = Auth::user()->pembeli;

        if (!$pembeli) {
            abort(404);
        }

        $pesanan = Pesanan::with(['items.listing', 'alamat.kecamatan', 'pembeli.user'])
            ->where('pembeli_id', $pembeli->id)
            ->findOrFail($id);
            
        return view('pembeli.pesanan.show', compact('pesanan'));
    }

    public function konfirmasiSelesai(Request $request, $id)
    {
        $request->validate([
            'foto_selesai' => 'required|image|max:2048'
        ]);

        $pembeli = Auth::user()->pembeli;

        if (!$pembeli) {
            abort(404);
        }

        $pesanan = Pesanan::where('pembeli_id', $pembeli->id)
            ->findOrFail($id);

        if ($pesanan->status !== 'dikirim') {
            return redirect()->back()->with('error', 'Pesanan belum dalam pengiriman.');
        }

        $path = ImageHelper::uploadAsWebp($request->file('foto_selesai'), 'pesanan/selesai');

        $pesanan->update([
            'status' => 'menunggu_verifikasi_selesai',
            'foto_selesai' => $path
        ]);

        // Trigger Loyalty Update (Keep it here or move to admin? Let's move to admin for finality)
        // $this->updateLoyalty($pesanan);

        // Notifikasi ke Pembeli
        \App\Models\Notifikasi::send(
            Auth::id(),
            'pesanan_terima_pembeli',
            'Konfirmasi Penerimaan Terkirim! 📦',
            "Bukti penerimaan untuk pesanan {$pesanan->kode_pesanan} telah terkirim. Mohon tunggu verifikasi admin untuk penyelesaian pesanan.",
            'pesanan',
            $pesanan->id
        );

        // Notifikasi ke Petani (diambil dari item pertama)
        $petaniId = $pesanan->items->first()->listing->petani->pengguna_id ?? null;
        if ($petaniId) {
            \App\Models\Notifikasi::send(
                $petaniId,
                'pesanan_selesai',
                'Dana Diteruskan 💸',
                "Pesanan {$pesanan->kode_pesanan} telah diterima pembeli. Dana akan segera diteruskan ke rekening Anda.",
                'pesanan',
                $pesanan->id
            );
        }

        return redirect()->back()->with('success', 'Pesanan telah selesai. Terima kasih telah berbelanja!');
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048'
        ]);

        $pembeli = Auth::user()->pembeli;
        $pesanan = Pesanan::where('pembeli_id', $pembeli->id)->findOrFail($id);

        if ($pesanan->status !== 'menunggu_bayar') {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibayar pada status ini.');
        }

        $path = ImageHelper::uploadAsWebp($request->file('bukti_pembayaran'), 'pesanan/bukti_bayar');

        $pesanan->update([
            'status' => 'menunggu_verifikasi',
            'bukti_pembayaran' => $path,
            'dibayar_pada' => now()
        ]);

        \App\Models\Notifikasi::send(
            Auth::id(),
            'pembayaran_dikirim',
            'Bukti Pembayaran Terkirim! ⏳',
            "Bukti pembayaran untuk pesanan {$pesanan->kode_pesanan} telah terkirim. Mohon tunggu verifikasi admin.",
            'pesanan',
            $pesanan->id
        );

        // Notifikasi ke Admin (jika ada sistem admin)
        // \App\Models\Notifikasi::sendToRole('admin', ...);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah. Mohon tunggu verifikasi admin.');
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:midtrans,transfer,cod'
        ]);

        $pembeli = Auth::user()->pembeli;
        $pesanan = Pesanan::where('pembeli_id', $pembeli->id)->findOrFail($id);

        if ($pesanan->status !== 'menunggu_bayar' && !($pesanan->status === 'menunggu_verifikasi' && $pesanan->metode_pembayaran === 'cod')) {
             return redirect()->back()->with('error', 'Metode pembayaran tidak bisa diubah pada status ini.');
        }

        $newMethod = $request->metode_pembayaran;
        
        $updateData = [
            'metode_pembayaran' => $newMethod,
            'status' => ($newMethod === 'cod') ? 'menunggu_verifikasi' : 'menunggu_bayar',
            'bukti_pembayaran' => null, // Reset proof if changing method
        ];

        if ($newMethod === 'midtrans') {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

            if (!config('services.midtrans.is_production')) {
                \Midtrans\Config::$curlOptions = [
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => [],
                ];
            }

            $user = Auth::user();
            $params = [
                'transaction_details' => [
                    'order_id' => $pesanan->kode_pesanan,
                    'gross_amount' => (int)$pesanan->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => $user->nama,
                    'email' => $user->email,
                ],
            ];

            if (config('services.midtrans.callback_url')) {
                $baseUrl = str_replace('/midtrans/callback', '', config('services.midtrans.callback_url'));
                $params['callbacks'] = [
                    'finish' => $baseUrl . '/pembeli/pesanan/' . $pesanan->id,
                    'unfinish' => $baseUrl . '/pembeli/pesanan/' . $pesanan->id,
                    'error' => $baseUrl . '/pembeli/pesanan/' . $pesanan->id,
                ];
                $params['notification_url'] = config('services.midtrans.callback_url');
            }

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $updateData['snap_token'] = $snapToken;
            } catch (\Exception $e) {
                \Log::error('Midtrans Token Error on Change Method:', ['message' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Gagal menghubungkan ke Midtrans: ' . $e->getMessage());
            }
        }

        $pesanan->update($updateData);

        return redirect()->back()->with('success', 'Metode pembayaran berhasil diubah ke ' . strtoupper($newMethod));
    }

    public function cancel($id)
    {
        $pembeli = Auth::user()->pembeli;
        $pesanan = Pesanan::where('pembeli_id', $pembeli->id)->findOrFail($id);

        if ($pesanan->status !== 'menunggu_bayar') {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibatalkan pada status ini.');
        }

        $pesanan->update(['status' => 'dibatalkan']);

        return redirect()->back()->with('success', 'Pesanan telah dibatalkan.');
    }

    private function updateLoyalty($pesanan)
    {
        $pembeli = Pembeli::find($pesanan->pembeli_id);
        
        // 1 poin per Rp 10.000 belanja
        $poinBaru = floor($pesanan->total_harga / 10000);
        $pembeli->poin_loyalitas += $poinBaru;
        
        if ($pembeli->poin_loyalitas > 2000) {
            $pembeli->tier_member = 'platinum';
        } elseif ($pembeli->poin_loyalitas > 500) {
            $pembeli->tier_member = 'gold';
        } else {
            $pembeli->tier_member = 'silver';
        }

        $pembeli->save();
    }
}
