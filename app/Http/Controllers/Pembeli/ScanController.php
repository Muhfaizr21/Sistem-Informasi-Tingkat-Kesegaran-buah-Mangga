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

            // Validasi gambar menggunakan PHP GD
            $imagePath = storage_path('app/public/' . $tempName);
            $imageInfo = @getimagesize($imagePath);
            
            if ($imageInfo === false) {
                Storage::disk('public')->delete($tempName);
                return response()->json([
                    'success' => false,
                    'message' => 'File gambar tidak valid atau rusak.'
                ], 422);
            }
            
            // Cek rasio warna dasar menggunakan PHP GD (sederhana)
            $isValidMango = $this->quickMangoCheck($imagePath);
            
            if (!$isValidMango) {
                Storage::disk('public')->delete($tempName);
                return response()->json([
                    'success' => false,
                    'message' => 'AI mendeteksi objek non-mangga. Pastikan hanya mangga yang terlihat jelas di kamera.'
                ], 422);
            }


            // Mengirim Gambar ke FastAPI Microservice (Lebih Cepat!)
            $imageAbsolutePath = storage_path('app/public/' . $tempName);
            
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(15)
                    ->attach('image', file_get_contents($imageAbsolutePath), 'scan.webp')
                    ->post('http://127.0.0.1:8001/api/scan', [
                        'jenis_mangga' => $request->jenis_mangga,
                    ]);

                if ($response->failed()) {
                    throw new \Exception('Server AI (FastAPI) mengembalikan error.');
                }
                
                $result = $response->json();
                
            } catch (\Exception $e) {
                Storage::disk('public')->delete($tempName);
                throw new \Exception('Gagal terhubung ke Server AI. Pastikan server FastAPI berjalan di http://127.0.0.1:8001. Error: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'analysis' => [
                    'skor_kesegaran' => $result['skor_kesegaran'],
                    'kategori' => $result['kategori'],
                    'rekomendasi' => $result['rekomendasi'],
                    'skor_kepercayaan' => $result['skor_kepercayaan'],
                    'persentase_warna' => $result['persentase_warna'],
                    'skor_tekstur' => $result['skor_tekstur'],
                    'skor_bentuk' => $result['skor_bentuk'],
                    'panjang_cm' => $result['panjang_cm'],
                    'berat_gr' => $result['berat_gr'],
                    'estimasi_ukuran' => $result['estimasi_ukuran'],
                    'skor_aroma' => $result['skor_aroma'],
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
                'berat_gram' => $request->berat_gr ?? 0,
                'diameter_cm' => $request->panjang_cm ?? 0,
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

    // Tambahkan method helper untuk pengecekan cepat (tanpa OpenCV)
    private function quickMangoCheck($imagePath)
    {
        if (!extension_loaded('gd')) {
            return true; // Jika GD tidak ada, lewati validasi
        }
        
        $img = @imagecreatefromstring(file_get_contents($imagePath));
        if (!$img) {
            return false;
        }
        
        $width = imagesx($img);
        $height = imagesy($img);
        $totalPixels = $width * $height;
        
        // Sample 1000 pixel random untuk cek warna dominan
        $samples = min(1000, $totalPixels);
        $mangoColorCount = 0;
        
        for ($i = 0; $i < $samples; $i++) {
            $x = rand(0, $width - 1);
            $y = rand(0, $height - 1);
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            
            // Warna mangga: R tinggi (kuning/oranye) atau G tinggi (hijau)
            // Tapi tidak boleh terlalu biru
            $isMangoColor = false;
            
            // Hijau (mentah) - Diperlebar
            if ($g > 80 && $g > $b) {
                $isMangoColor = true;
            }
            // Kuning/Oranye (matang) - Diperlebar
            if ($r > 90 && $g > 50 && $r > $b) {
                $isMangoColor = true;
            }
            
            if ($isMangoColor) {
                $mangoColorCount++;
            }
        }
        
        imagedestroy($img);
        
        $rasioWarnaMangga = $mangoColorCount / $samples;
        
        // Turunkan threshold menjadi 5% untuk mengakomodasi foto dengan background luas
    // Relaxed threshold to 0.02 (2%) to be less aggressive
    return $rasioWarnaMangga > 0.02;
    }
}
