<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\ListingMangga;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = ListingMangga::with(['petani.user', 'lahan.kecamatan'])
            ->where('aktif', true);

        // Filter Varietas
        if ($request->has('varietas') && !empty($request->varietas)) {
            $query->where('jenis_mangga', 'like', '%' . $request->varietas . '%');
        }

        // Filter Kecamatan
        if ($request->has('kecamatan') && !empty($request->kecamatan)) {
            $query->whereHas('lahan', function($q) use ($request) {
                $q->where('kecamatan_id', $request->kecamatan);
            });
        }

        // Filter Harga
        if ($request->has('min_harga') && !empty($request->min_harga)) {
            $query->where('harga_per_kg', '>=', $request->min_harga);
        }
        if ($request->has('max_harga') && !empty($request->max_harga)) {
            $query->where('harga_per_kg', '<=', $request->max_harga);
        }

        $listings = $query->latest()->paginate(12);
        $kecamatans = Kecamatan::orderBy('nama')->get();

        return view('pembeli.marketplace.katalog', compact('listings', 'kecamatans'));
    }

    public function show($id)
    {
        $listing = ListingMangga::with(['petani.user', 'lahan.kecamatan', 'petani.review.pembeli.user'])
            ->findOrFail($id);
            
        return view('pembeli.marketplace.detail', compact('listing'));
    }
}
