<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\ListingMangga;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $listings = $query->select('listing_mangga.*')
            ->addSelect([
                'average_rating' => DB::table('review')
                    ->join('pesanan', 'review.pesanan_id', '=', 'pesanan.id')
                    ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
                    ->whereColumn('detail_pesanan.listing_id', 'listing_mangga.id')
                    ->selectRaw('AVG(rating)'),
                'review_count' => DB::table('review')
                    ->join('pesanan', 'review.pesanan_id', '=', 'pesanan.id')
                    ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
                    ->whereColumn('detail_pesanan.listing_id', 'listing_mangga.id')
                    ->selectRaw('COUNT(review.id)')
            ])
            ->latest('listing_mangga.created_at')
            ->paginate(10);
        $kecamatans = Kecamatan::orderBy('nama')->get();

        return view('pembeli.marketplace.katalog', compact('listings', 'kecamatans'));
    }

    public function show($id)
    {
        $listing = ListingMangga::with(['petani.user', 'lahan.kecamatan'])
            ->addSelect([
                'average_rating' => DB::table('review')
                    ->join('pesanan', 'review.pesanan_id', '=', 'pesanan.id')
                    ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
                    ->whereColumn('detail_pesanan.listing_id', 'listing_mangga.id')
                    ->selectRaw('AVG(rating)'),
                'review_count' => DB::table('review')
                    ->join('pesanan', 'review.pesanan_id', '=', 'pesanan.id')
                    ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
                    ->whereColumn('detail_pesanan.listing_id', 'listing_mangga.id')
                    ->selectRaw('COUNT(review.id)')
            ])
            ->findOrFail($id);

        $reviews = \App\Models\Review::with('pembeli.user')
            ->join('pesanan', 'review.pesanan_id', '=', 'pesanan.id')
            ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('detail_pesanan.listing_id', $id)
            ->select('review.*')
            ->latest()
            ->get();
            
        return view('pembeli.marketplace.detail', compact('listing', 'reviews'));
    }

    public function reviews($id)
    {
        $listing = ListingMangga::with(['petani.user'])->findOrFail($id);
        
        $reviews = \App\Models\Review::with('pembeli.user')
            ->join('pesanan', 'review.pesanan_id', '=', 'pesanan.id')
            ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->where('detail_pesanan.listing_id', $id)
            ->select('review.*')
            ->latest()
            ->paginate(20);

        return view('pembeli.marketplace.reviews', compact('listing', 'reviews'));
    }
}
