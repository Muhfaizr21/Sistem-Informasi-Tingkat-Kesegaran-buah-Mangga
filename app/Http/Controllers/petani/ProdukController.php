<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\ListingMangga;
use App\Models\Petani;
use App\Models\Lahan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $petani = Petani::firstOrCreate(['pengguna_id' => auth()->id()]);
        
        $produk = ListingMangga::where('petani_id', $petani->id)
            ->with('lahan')
            ->latest()
            ->get();

        return view('petani.produk.index', compact('produk'));
    }

    public function edit($id)
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        if (!$petani) {
            return redirect()->back()->with('error', 'Profil petani tidak ditemukan.');
        }

        $produk = ListingMangga::where('id', $id)->where('petani_id', $petani->id)->firstOrFail();
        $lahan = Lahan::where('petani_id', $petani->id)->get();

        return view('petani.produk.edit', compact('produk', 'lahan'));
    }

    public function update(Request $request, $id)
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        if (!$petani) {
            return redirect()->back()->with('error', 'Profil petani tidak ditemukan.');
        }

        $produk = ListingMangga::where('id', $id)->where('petani_id', $petani->id)->firstOrFail();

        $request->validate([
            'lahan_id' => 'required|exists:lahan,id',
            'jenis_mangga' => 'required|string|max:100',
            'harga_per_kg' => 'required|numeric|min:0',
            'stok_tersedia_kg' => 'required|numeric|min:0',
            'minimal_order_kg' => 'required|numeric|min:0.1',
            'deskripsi' => 'nullable|string',
            'aktif' => 'nullable',
        ]);

        $produk->update([
            'lahan_id' => $request->lahan_id,
            'jenis_mangga' => $request->jenis_mangga,
            'harga_per_kg' => $request->harga_per_kg,
            'stok_tersedia_kg' => $request->stok_tersedia_kg,
            'minimal_order_kg' => $request->minimal_order_kg,
            'deskripsi' => $request->deskripsi ?? 'Mangga segar hasil scan AI.',
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()->route('petani.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        $listing = ListingMangga::where('id', $id)->where('petani_id', $petani->id)->firstOrFail();
        
        $listing->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari marketplace.');
    }

    public function toggleStatus($id)
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        $listing = ListingMangga::where('id', $id)->where('petani_id', $petani->id)->firstOrFail();
        
        $listing->aktif = !$listing->aktif;
        $listing->save();

        return redirect()->back()->with('success', 'Status produk berhasil diperbarui.');
    }
}
