<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanKesegaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function index()
    {
        $pembeliId = Auth::user()->pembeli?->id;
        
        $history = ScanKesegaran::where('pembeli_id', $pembeliId)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

        return view('pembeli.scan', compact('history'));
    }

    public function proses(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required',
                'jenis_mangga' => 'required|string'
            ]);

            // Simpan Foto ke Temp
            $img = $request->image;
            $img = preg_replace('/^data:image\/\w+;base64,/', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $tempName = 'scan/temp/' . Str::random(10) . '_' . time() . '.webp';
            Storage::disk('public')->put($tempName, $data);

            // Simulasi Deteksi Objek (Mangga atau Bukan)
            if (rand(1, 20) === 1) { // 5% failure rate for a smoother demo experience
                Storage::disk('public')->delete($tempName);
                return response()->json([
                    'success' => false,
                    'message' => 'AI mendeteksi objek non-mangga (Manusia/Tangan). Pastikan hanya objek mangga yang terlihat jelas di kamera.'
                ], 422);
            }

            // Simulasi Algoritma
            $skorKesegaran = rand(70, 98);
            $kategori = $this->tentukanKategori($skorKesegaran);
            $rekomendasi = $this->tentukanRekomendasi($kategori);

            return response()->json([
                'success' => true,
                'analysis' => [
                    'skor_kesegaran' => $skorKesegaran,
                    'kategori' => $kategori,
                    'rekomendasi' => $rekomendasi,
                    'skor_kepercayaan' => rand(85, 99),
                    'persentase_warna' => rand(60, 95),
                    'skor_tekstur' => rand(75, 95),
                    'skor_bentuk' => rand(80, 95),
                    'skor_aroma' => rand(75, 98),
                ],
                'temp_path' => $tempName,
                'image_url' => asset('storage/' . $tempName)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function simpan(Request $request)
    {
        try {
            $pembeliId = Auth::user()->pembeli?->id;
            $tempPath = $request->temp_path;
            
            if (!Storage::disk('public')->exists($tempPath)) {
                return response()->json(['success' => false, 'message' => 'File tidak ditemukan.'], 404);
            }

            // Move to permanent
            $permanentPath = str_replace('temp/', '', $tempPath);
            Storage::disk('public')->move($tempPath, $permanentPath);

            $scan = ScanKesegaran::create([
                'pembeli_id' => $pembeliId,
                'path_foto' => $permanentPath,
                'jenis_mangga' => $request->jenis_mangga,
                'skor_kesegaran' => $request->skor_kesegaran,
                'persentase_warna' => $request->persentase_warna,
                'skor_tekstur' => $request->skor_tekstur,
                'skor_bentuk' => $request->skor_bentuk,
                'skor_aroma' => $request->skor_aroma,
                'skor_kepercayaan' => $request->skor_kepercayaan,
                'kategori' => $request->kategori,
                'rekomendasi' => $request->rekomendasi,
                'dipindai_pada' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Hasil scan berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function batal(Request $request)
    {
        if ($request->temp_path && Storage::disk('public')->exists($request->temp_path)) {
            Storage::disk('public')->delete($request->temp_path);
        }
        return response()->json(['success' => true]);
    }

    private function tentukanKategori($skor)
    {
        if ($skor >= 90) return 'matang';
        if ($skor >= 80) return 'sangat_matang';
        if ($skor >= 70) return 'setengah_matang';
        return 'mentah';
    }

    private function tentukanRekomendasi($kategori)
    {
        if ($kategori == 'matang') return 'siap_jual';
        if ($kategori == 'setengah_matang') return 'perlu_penyimpanan';
        return 'belum_siap';
    }
}
