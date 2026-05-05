<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\AlamatPengiriman;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pembeli.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $pembeli = Auth::user()->pembeli;
        $alamats = AlamatPengiriman::where('pembeli_id', $pembeli->id)->get();
        $kecamatans = Kecamatan::orderBy('nama')->get();
        
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['harga'] * $item['jumlah'];
        }

        return view('pembeli.marketplace.checkout', compact('cart', 'totalPrice', 'alamats', 'kecamatans'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'alamat_id' => 'required',
            'metode_pengiriman' => 'required',
            'metode_pembayaran' => 'required',
        ]);

        $cart = session()->get('cart', []);
        $pembeli = Auth::user()->pembeli;
        
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['harga'] * $item['jumlah'];
        }

        // Loyalty Discount
        $diskonPercent = 0;
        if ($pembeli->tier_member === 'gold') $diskonPercent = 0.05;
        elseif ($pembeli->tier_member === 'platinum') $diskonPercent = 0.10;
        
        $diskon = $totalPrice * $diskonPercent;
        $ongkir = 15000; // Flat ongkir for demo
        $totalBayar = ($totalPrice - $diskon) + $ongkir;

        try {
            DB::beginTransaction();

            $pesanan = Pesanan::create([
                'kode_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
                'pembeli_id' => $pembeli->id,
                'total_harga' => $totalPrice,
                'biaya_pengiriman' => $ongkir,
                'diskon' => $diskon,
                'total_bayar' => $totalBayar,
                'alamat_id' => $request->alamat_id,
                'metode_pengiriman' => $request->metode_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'menunggu_bayar',
            ]);

            foreach ($cart as $id => $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'listing_id' => $id,
                    'petani_id' => $item['petani_id'],
                    'jumlah_kg' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                ]);
                
                // Update stock logic could go here
            }

            session()->forget('cart');
            DB::commit();

            return redirect()->route('pembeli.dashboard')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
