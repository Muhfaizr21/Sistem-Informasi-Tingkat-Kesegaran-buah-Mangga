<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\LaporanPanen;
use App\Models\Lahan;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Helpers\ImageHelper;

class LaporanPanenController extends Controller
{
    public function index(Request $request)
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        $query = LaporanPanen::where('petani_id', $petani->id ?? 0)->with('lahan');

        if ($request->lahan_id) {
            $query->where('lahan_id', $request->lahan_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest('tanggal_panen')->get();
        $lahan = Lahan::where('petani_id', $petani->id ?? 0)->get();

        // Stats for the view
        $totalKg = $reports->sum('jumlah_kg');
        $avgPerLahan = $lahan->count() > 0 ? $totalKg / $lahan->count() : 0;

        return view('petani.laporan-panen', compact('reports', 'lahan', 'totalKg', 'avgPerLahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahan,id',
            'tanggal_panen' => 'required|date',
            'jumlah_kg' => 'required|numeric',
            'jenis_mangga' => 'required|string',
            'kondisi_cuaca' => 'nullable|string',
            'catatan' => 'nullable|string',
            'foto_panen.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $petani = Petani::where('pengguna_id', auth()->id())->first();

        $fotos = [];
        if ($request->hasFile('foto_panen')) {
            foreach ($request->file('foto_panen') as $file) {
                $path = ImageHelper::uploadAsWebp($file, 'panen');
                $fotos[] = $path;
            }
        }

        LaporanPanen::create([
            'petani_id' => $petani->id,
            'lahan_id' => $request->lahan_id,
            'tanggal_panen' => $request->tanggal_panen,
            'jumlah_kg' => $request->jumlah_kg,
            'jenis_mangga' => $request->jenis_mangga,
            'kondisi_cuaca' => $request->kondisi_cuaca,
            'catatan' => $request->catatan,
            'foto_panen' => $fotos,
            'status' => 'submitted'
        ]);

        return back()->with('success', 'Laporan panen berhasil dikirim untuk verifikasi!');
    }

    public function update(Request $request, LaporanPanen $laporan)
    {
        if ($laporan->status === 'verified') {
            return back()->with('error', 'Laporan yang sudah diverifikasi tidak dapat diubah.');
        }

        $request->validate([
            'jumlah_kg' => 'required|numeric',
            'kondisi_cuaca' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $fotos = $laporan->foto_panen ?? [];
        if ($request->hasFile('foto_panen')) {
            foreach ($request->file('foto_panen') as $file) {
                $path = ImageHelper::uploadAsWebp($file, 'panen');
                $fotos[] = $path;
            }
        }

        $laporan->update([
            'jumlah_kg' => $request->jumlah_kg,
            'kondisi_cuaca' => $request->kondisi_cuaca,
            'catatan' => $request->catatan,
            'foto_panen' => $fotos,
        ]);

        return back()->with('success', 'Laporan panen berhasil diperbarui!');
    }
}
