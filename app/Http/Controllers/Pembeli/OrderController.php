<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $pembeli = Auth::user()->pembeli;
        
        if (!$pembeli) {
            return view('pembeli.pesanan.index', ['pesanans' => collect()]);
        }

        $pesanans = Pesanan::with(['items.listing'])
            ->where('pembeli_id', $pembeli->id)
            ->latest()
            ->paginate(10);

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

    public function konfirmasiSelesai($id)
    {
        $pembeli = Auth::user()->pembeli;

        if (!$pembeli) {
            abort(404);
        }

        $pesanan = Pesanan::where('pembeli_id', $pembeli->id)
            ->findOrFail($id);

        if ($pesanan->status !== 'dikirim') {
            return redirect()->back()->with('error', 'Pesanan belum dalam pengiriman.');
        }

        $pesanan->update([
            'status' => 'selesai',
            'selesai_pada' => now()
        ]);

        // Trigger Loyalty Update
        $this->updateLoyalty($pesanan);

        // Notifikasi ke Pembeli
        \App\Models\Notifikasi::send(
            Auth::id(),
            'pesanan_selesai',
            'Pesanan Selesai! 🎉',
            "Pesanan {$pesanan->kode_pesanan} telah Anda terima. Silakan berikan ulasan.",
            'pesanan',
            $pesanan->id
        );

        // Notifikasi ke Petani (diambil dari item pertama)
        $petaniId = $pesanan->items->first()->petani?->pengguna_id;
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

    private function updateLoyalty($pesanan)
    {
        $pembeli = Pembeli::find($pesanan->pembeli_id);
        
        // 1 poin per Rp 10.000 belanja
        $poinBaru = floor($pesanan->total_harga / 10000);
        $pembeli->poin_loyalitas += $poinBaru;
        
        // Recalculate Tier
        // Silver: 0-500 poin
        // Gold: 501-2000 poin
        // Platinum: > 2000 poin
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
