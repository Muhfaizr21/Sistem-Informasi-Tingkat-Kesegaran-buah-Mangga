<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ListingMangga;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil profil pembeli
        $pembeli = $user->pembeli;
        
        // Data stats
        $stats = [
            'total_scan' => $pembeli ? $pembeli->scans()->count() : 0, 
            'total_pesanan' => $pembeli ? $pembeli->pesanan()->count() : 0,
        ];

        // Ambil 2 listing terbaru untuk preview
        $recent_listings = ListingMangga::with(['petani.user', 'lahan.kecamatan'])
            ->where('aktif', true)
            ->latest()
            ->limit(2)
            ->get();

        // Ambil petani favorit
        $favorite_petani = [];
        if ($pembeli) {
            $favorite_petani = \App\Models\Favorit::with(['petani.user', 'petani.listings' => function($q) {
                $q->where('aktif', true);
            }])
                ->where('pembeli_id', $pembeli->id)
                ->latest()
                ->limit(3)
                ->get();
        }

        return view('pembeli.dashboard', compact('user', 'stats', 'recent_listings', 'favorite_petani'));
    }
}
