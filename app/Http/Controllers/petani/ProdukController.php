<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\ListingMangga;
use App\Models\Petani;
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
