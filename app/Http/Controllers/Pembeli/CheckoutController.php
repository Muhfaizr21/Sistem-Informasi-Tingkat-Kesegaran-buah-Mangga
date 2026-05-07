<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\AlamatPengiriman;
use App\Models\ListingMangga;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        try {
            $cart = session()->get('cart', []);
            
            if (empty($cart) || !is_array($cart)) {
                return redirect()->route('pembeli.cart.index')->with('error', 'Keranjang Anda kosong.');
            }

            $user = Auth::user();
            $pembeli = $user->pembeli;
            
            if (!$pembeli) {
                \Log::warning('Checkout Index - Pembeli profile missing for user:', ['user_id' => $user->id]);
                return redirect()->route('pembeli.dashboard')->with('error', 'Profil pembeli tidak ditemukan. Silakan lengkapi profil Anda.');
            }
            
            $alamats = AlamatPengiriman::where('pembeli_id', $pembeli->id)->with('kecamatan')->get();
            $kecamatans = Kecamatan::orderBy('nama')->get();
            
            $totalPrice = 0;
            $hasChanges = false;
            $validatedCart = [];

            foreach ($cart as $id => $item) {
                // Defensive check for item structure
                if (!is_array($item)) {
                    $hasChanges = true;
                    continue;
                }

                $listing = ListingMangga::find($id);
                if (!$listing || !$listing->aktif || $listing->stok_tersedia_kg <= 0) {
                    $hasChanges = true;
                    continue;
                }
                
                $qty = (float)($item['jumlah'] ?? 1);
                if ($qty > $listing->stok_tersedia_kg) {
                    $qty = (float)$listing->stok_tersedia_kg;
                    $hasChanges = true;
                }

                if ($qty <= 0) {
                    $hasChanges = true;
                    continue;
                }

                $validatedCart[$id] = $item;
                $validatedCart[$id]['jumlah'] = $qty;
                $validatedCart[$id]['harga'] = (float)($item['harga'] ?? $listing->harga_per_kg);
                
                $totalPrice += $validatedCart[$id]['harga'] * $qty;
            }

            if ($hasChanges) {
                session()->put('cart', $validatedCart);
                if (empty($validatedCart)) {
                    return redirect()->route('pembeli.cart.index')->with('error', 'Produk di keranjang Anda sudah tidak tersedia.');
                }
            }

            return view('pembeli.marketplace.checkout', [
                'cart' => $validatedCart,
                'totalPrice' => $totalPrice,
                'alamats' => $alamats,
                'kecamatans' => $kecamatans
            ]);

        } catch (\Exception $e) {
            \Log::error('Checkout Index Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('pembeli.cart.index')->with('error', 'Terjadi kesalahan saat memuat halaman checkout.');
        }
    }

    public function process(Request $request)
    {
        $request->validate([
            'alamat_id' => 'required|exists:alamat_pengiriman,id',
            'metode_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string|in:midtrans,transfer,cod',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart) || !is_array($cart)) {
            return redirect()->route('pembeli.cart.index')->with('error', 'Keranjang kosong.');
        }

        $user = Auth::user();
        $pembeli = $user->pembeli;
        if (!$pembeli) {
            return redirect()->route('pembeli.dashboard')->with('error', 'Profil pembeli tidak ditemukan.');
        }
        
        try {
            DB::beginTransaction();

            $totalPrice = 0;
            $itemsToProcess = [];

            foreach ($cart as $id => $item) {
                if (!is_array($item)) continue;

                $listing = ListingMangga::find($id);
                if (!$listing) {
                    throw new \Exception("Produk dengan ID {$id} tidak lagi tersedia.");
                }
                
                $qty = (float)($item['jumlah'] ?? 0);
                if ($listing->stok_tersedia_kg < $qty) {
                    throw new \Exception("Stok {$listing->jenis_mangga} tidak mencukupi. Tersisa {$listing->stok_tersedia_kg} kg.");
                }

                $hargaSatuan = (float)($item['harga'] ?? $listing->harga_per_kg);
                $subtotal = $hargaSatuan * $qty;
                
                $itemsToProcess[] = [
                    'listing_id' => $id,
                    'listing_obj' => $listing,
                    'petani_id' => $item['petani_id'] ?? $listing->petani_id,
                    'jumlah_kg' => $qty,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal,
                ];

                $totalPrice += $subtotal;
            }

            if (empty($itemsToProcess)) {
                throw new \Exception("Tidak ada produk valid untuk diproses.");
            }

            // Loyalty Discount
            $diskonPercent = 0;
            if ($pembeli->tier_member === 'gold') $diskonPercent = 0.05;
            elseif ($pembeli->tier_member === 'platinum') $diskonPercent = 0.10;
            
            $diskon = $totalPrice * $diskonPercent;
            $ongkir = (float)($request->biaya_pengiriman ?? 15000); 
            $biayaLayanan = 2500.0;
            $totalBayar = ($totalPrice - $diskon) + $ongkir + $biayaLayanan;

            $pesanan = Pesanan::create([
                'kode_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
                'pembeli_id' => $pembeli->id,
                'total_harga' => $totalPrice,
                'biaya_pengiriman' => $ongkir,
                'biaya_layanan' => $biayaLayanan,
                'diskon' => $diskon,
                'total_bayar' => $totalBayar,
                'alamat_id' => $request->alamat_id,
                'metode_pengiriman' => $request->metode_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => ($request->metode_pembayaran === 'cod') ? 'menunggu_verifikasi' : 'menunggu_bayar',
            ]);

            foreach ($itemsToProcess as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'listing_id' => $item['listing_id'],
                    'petani_id' => $item['petani_id'],
                    'jumlah_kg' => $item['jumlah_kg'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal'],
                ]);
                
                // Update stock
                $item['listing_obj']->decrement('stok_tersedia_kg', $item['jumlah_kg']);
            }

            // Midtrans Integration if selected
            if ($request->metode_pembayaran === 'midtrans') {
                \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

                if (!config('services.midtrans.is_production')) {
                    \Midtrans\Config::$curlOptions = [
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_HTTPHEADER => [], // Defensive fix for Midtrans SDK bug with PHP 8
                    ];
                }

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

                // Append notification_url and redirect URLs
                if (config('services.midtrans.callback_url')) {
                    $baseUrl = str_replace('/midtrans/callback', '', config('services.midtrans.callback_url'));
                    
                    $params['callbacks'] = [
                        'finish' => $baseUrl . '/pembeli/pesanan/' . $pesanan->id,
                        'unfinish' => $baseUrl . '/pembeli/pesanan/' . $pesanan->id,
                        'error' => $baseUrl . '/pembeli/pesanan/' . $pesanan->id,
                    ];
                    
                    $params['notification_url'] = config('services.midtrans.callback_url');
                }

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $pesanan->update(['snap_token' => $snapToken]);
            }

            session()->forget('cart');
            DB::commit();

            return redirect()->route('pembeli.pesanan.show', $pesanan->id)->with('success', 'Pesanan berhasil dibuat! Silakan ikuti instruksi pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Process Checkout Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
