<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\ListingMangga;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Group items by farmer
        $groupedCart = [];
        $totalPrice = 0;
        
        foreach ($cart as $id => $details) {
            $petaniId = $details['petani_id'];
            if (!isset($groupedCart[$petaniId])) {
                $groupedCart[$petaniId] = [
                    'petani_nama' => $details['petani_nama'],
                    'items' => []
                ];
            }
            $groupedCart[$petaniId]['items'][$id] = $details;
            $totalPrice += $details['harga'] * $details['jumlah'];
        }

        return view('pembeli.marketplace.cart', compact('groupedCart', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $listing = ListingMangga::with('petani.user')->findOrFail($request->listing_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$listing->id])) {
            $cart[$listing->id]['jumlah'] += $request->jumlah_kg;
        } else {
            $cart[$listing->id] = [
                "nama" => $listing->jenis_mangga,
                "jumlah" => $request->jumlah_kg,
                "harga" => $listing->harga_per_kg,
                "foto" => $listing->foto_batch[0] ?? null,
                "petani_id" => $listing->petani_id,
                "petani_nama" => $listing->petani->user->nama,
                "minimal_order" => $listing->minimal_order_kg
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Mangga berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->jumlah){
            $cart = session()->get('cart');
            $cart[$request->id]["jumlah"] = $request->jumlah;
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Item berhasil dihapus.');
        }
    }
}
