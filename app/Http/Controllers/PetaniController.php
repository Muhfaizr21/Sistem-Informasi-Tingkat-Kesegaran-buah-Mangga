<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaniController extends Controller
{
    public function dashboard()
    {
        return view('petani.dashboard');
    }

    public function cekKesegaran()
    {
        return view('petani.cek-kesegaran');
    }

    public function dataLahan()
    {
        return view('petani.data-lahan');
    }

    public function laporanPanen()
    {
        $reports = \App\Models\HarvestReport::where('user_id', auth()->id())->latest()->get();
        return view('petani.laporan-panen', compact('reports'));
    }

    public function storeLaporanPanen(Request $request)
    {
        $request->validate([
            'variety' => 'required|string',
            'weight' => 'required|numeric',
            'location' => 'required|string',
            'grade' => 'required|string',
            'note' => 'nullable|string',
        ]);

        \App\Models\HarvestReport::create([
            'user_id' => auth()->id(),
            'variety' => $request->variety,
            'weight' => $request->weight,
            'location' => $request->location,
            'grade' => $request->grade,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Laporan panen berhasil disimpan!');
    }

    public function profil()
    {
        return view('petani.profil');
    }
}
