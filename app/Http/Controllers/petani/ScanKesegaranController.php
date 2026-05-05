<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\ScanKesegaran;
use App\Models\Lahan;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ScanKesegaranController extends Controller
{
    public function index()
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        $lahan = Lahan::where('petani_id', $petani->id ?? 0)->get();
        
        return view('petani.cek-kesegaran', compact('lahan'));
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Base64 image
            'jenis_mangga' => 'required|string',
            'berat_gram' => 'nullable|numeric',
            'diameter_cm' => 'nullable|numeric',
            'lahan_id' => 'nullable|exists:lahan,id'
        ]);

        // Mock CV Analysis Logic
        $skorKesegaran = rand(60, 95);
        $persentaseWarna = rand(40, 90);
        $skorTekstur = rand(70, 98);
        $skorKepercayaan = rand(85, 99);
        
        $kategori = 'matang';
        if ($persentaseWarna < 30) $kategori = 'mentah';
        elseif ($persentaseWarna < 60) $kategori = 'setengah_matang';
        elseif ($persentaseWarna > 85) $kategori = 'sangat_matang';

        $rekomendasi = 'siap_jual';
        if ($skorKesegaran < 50) $rekomendasi = 'belum_siap';
        elseif ($skorKesegaran < 75) $rekomendasi = 'perlu_penyimpanan';

        return response()->json([
            'status' => 'success',
            'data' => [
                'skor_kesegaran' => $skorKesegaran,
                'persentase_warna' => $persentaseWarna,
                'skor_tekstur' => $skorTekstur,
                'skor_kepercayaan' => $skorKepercayaan,
                'kategori' => $kategori,
                'rekomendasi' => $rekomendasi,
                'cacat_terdeteksi' => rand(0, 10) > 8,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'jenis_mangga' => 'required|string',
            'berat_gram' => 'nullable|numeric',
            'diameter_cm' => 'nullable|numeric',
            'lahan_id' => 'nullable|exists:lahan,id',
            'results' => 'required|array'
        ]);

        $petani = Petani::where('pengguna_id', auth()->id())->first();
        
        // Save Image
        $imageData = $request->image;
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageName = 'scan_' . time() . '.jpg';
        Storage::disk('public')->put('scans/' . $imageName, base64_decode($imageData));

        $scan = ScanKesegaran::create([
            'petani_id' => $petani->id,
            'lahan_id' => $request->lahan_id,
            'path_foto' => 'scans/' . $imageName,
            'berat_gram' => $request->berat_gram,
            'diameter_cm' => $request->diameter_cm,
            'jenis_mangga' => $request->jenis_mangga,
            'skor_kesegaran' => $request->results['skor_kesegaran'],
            'persentase_warna' => $request->results['persentase_warna'],
            'skor_tekstur' => $request->results['skor_tekstur'],
            'cacat_terdeteksi' => $request->results['cacat_terdeteksi'],
            'kategori' => $request->results['kategori'],
            'rekomendasi' => $request->results['rekomendasi'],
            'skor_kepercayaan' => $request->results['skor_kepercayaan'],
            'batch_id' => 'BATCH-' . strtoupper(substr(md5(time()), 0, 8)),
            'dipindai_pada' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hasil scan berhasil disimpan!',
            'scan_id' => $scan->id
        ]);
    }
}
