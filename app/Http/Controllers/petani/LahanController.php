<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\Lahan;
use App\Models\Kecamatan;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class LahanController extends Controller
{
    public function index()
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        $lahan = Lahan::where('petani_id', $petani->id ?? 0)->latest()->get();
        $kecamatan = Kecamatan::all();
        
        return view('petani.data-lahan', compact('lahan', 'kecamatan'));
    }

    public function syncKecamatan(Request $request)
    {
        $name = $request->name;
        if (!$name) return response()->json(['error' => 'Name required'], 400);

        $cleanName = trim(preg_replace('/kecamatan|kec\./i', '', $name));
        
        // Find by name (case insensitive) or create
        $kecamatan = Kecamatan::where('nama', 'LIKE', $cleanName)->first();
        
        if (!$kecamatan) {
            $kecamatan = Kecamatan::create([
                'nama' => $cleanName,
                'kode_bps' => substr(uniqid(), 0, 10)
            ]);
        }
        
        return response()->json([
            'id' => $kecamatan->id,
            'nama' => $kecamatan->nama
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'desa' => 'nullable|string|max:100',
            'luas_hektar' => 'required|numeric',
            'jenis_mangga' => 'required|string',
            'jumlah_pohon' => 'required|integer',
            'tahun_tanam' => 'required|integer',
            'status' => 'required|in:produktif,persiapan,tidak_aktif',
            'foto_lahan.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $petani = Petani::where('pengguna_id', auth()->id())->first();
        
        $fotos = [];
        if ($request->hasFile('foto_lahan')) {
            foreach ($request->file('foto_lahan') as $file) {
                $path = ImageHelper::uploadAsWebp($file, 'lahan');
                $fotos[] = $path;
            }
        }

        Lahan::create([
            'petani_id' => $petani->id,
            'nama_lahan' => $request->nama_lahan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'koordinat_polygon' => $request->koordinat_polygon ? json_decode($request->koordinat_polygon) : null,
            'kecamatan_id' => $request->kecamatan_id,
            'desa' => $request->desa,
            'luas_hektar' => $request->luas_hektar,
            'jenis_mangga' => $request->jenis_mangga,
            'jumlah_pohon' => $request->jumlah_pohon,
            'tahun_tanam' => $request->tahun_tanam,
            'status' => $request->status,
            'foto_lahan' => $fotos,
        ]);

        return back()->with('success', 'Data lahan berhasil ditambahkan!');
    }

    public function update(Request $request, Lahan $lahan)
    {
        $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'luas_hektar' => 'required|numeric',
            'status' => 'required|in:produktif,persiapan,tidak_aktif',
        ]);

        $fotos = $lahan->foto_lahan ?? [];
        if ($request->hasFile('foto_lahan')) {
            foreach ($request->file('foto_lahan') as $file) {
                $path = ImageHelper::uploadAndConvert($file, 'lahan');
                $fotos[] = $path;
            }
        }

        $lahan->update([
            'nama_lahan' => $request->nama_lahan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'koordinat_polygon' => $request->koordinat_polygon ? json_decode($request->koordinat_polygon) : $lahan->koordinat_polygon,
            'kecamatan_id' => $request->kecamatan_id,
            'luas_hektar' => $request->luas_hektar,
            'status' => $request->status,
            'foto_lahan' => $fotos,
        ]);

        return back()->with('success', 'Data lahan berhasil diperbarui!');
    }

    public function destroy(Lahan $lahan)
    {
        $lahan->delete(); // Soft delete
        return back()->with('success', 'Data lahan berhasil dihapus!');
    }
}
