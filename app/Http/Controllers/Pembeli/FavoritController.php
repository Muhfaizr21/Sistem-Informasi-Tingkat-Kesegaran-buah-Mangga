<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorit;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'petani_id' => 'required|exists:petani,id'
        ]);

        $pembeliId = Auth::user()->pembeli?->id;
        if (!$pembeliId) {
            return response()->json(['message' => 'Profil pembeli tidak ditemukan.'], 403);
        }

        $favorit = Favorit::where('pembeli_id', $pembeliId)
            ->where('petani_id', $request->petani_id)
            ->first();

        if ($favorit) {
            $favorit->delete();
            return response()->json(['status' => 'removed', 'message' => 'Dihapus dari favorit.']);
        } else {
            Favorit::create([
                'pembeli_id' => $pembeliId,
                'petani_id' => $request->petani_id
            ]);
            return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke favorit.']);
        }
    }

    public function index()
    {
        $pembeliId = Auth::user()->pembeli?->id;
        $favorites = Favorit::with(['petani.user', 'petani.listings' => function($q) {
            $q->where('aktif', true);
        }])
        ->where('pembeli_id', $pembeliId)
        ->latest()
        ->paginate(12);

        return view('pembeli.favorit.index', compact('favorites'));
    }
}
