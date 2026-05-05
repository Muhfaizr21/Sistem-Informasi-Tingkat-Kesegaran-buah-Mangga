<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Petani;
use Illuminate\Http\Request;

class PetaniController extends Controller
{
    public function show($id)
    {
        $petani = Petani::with(['user', 'lahan.kecamatan', 'listings' => function($q) {
            $q->where('aktif', true);
        }, 'review.pembeli.user'])->findOrFail($id);
        
        $pembeli = auth()->user()->pembeli;
        $isFavorited = false;
        if ($pembeli) {
            $isFavorited = \App\Models\Favorit::where('pembeli_id', $pembeli->id)
                ->where('petani_id', $id)
                ->exists();
        }
        
        return view('pembeli.marketplace.profil-petani', compact('petani', 'isFavorited'));
    }
}
