<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Petani;
use Illuminate\Http\Request;

class PetaniController extends Controller
{
    public function show($id)
    {
        $petani = Petani::with([
            'user', 
            'lahan.kecamatan', 
            'listings' => function($q) {
                $q->where('aktif', true);
            }, 
            'review.pembeli.user'
        ])
        ->withCount(['lahan', 'review'])
        ->withAvg('review', 'rating')
        ->findOrFail($id);
        
        $varietasCount = $petani->listings()->where('aktif', true)->distinct('jenis_mangga')->count('jenis_mangga');
        
        $latestHarvests = \App\Models\LaporanPanen::with('lahan')
            ->where('petani_id', $id)
            ->where('status', 'terverifikasi')
            ->latest('tanggal_panen')
            ->take(5)
            ->get();
        
        $pembeli = auth()->user()->pembeli;
        $isFavorited = false;
        if ($pembeli) {
            $isFavorited = \App\Models\Favorit::where('pembeli_id', $pembeli->id)
                ->where('petani_id', $id)
                ->exists();
        }
        
        return view('pembeli.marketplace.profil-petani', compact(
            'petani', 
            'isFavorited', 
            'varietasCount', 
            'latestHarvests'
        ));
    }
}
