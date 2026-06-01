<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\ScanKesegaran;
use App\Models\Lahan;
use App\Models\Petani;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        try {
            $request->validate([
                'image' => 'required|string', // Base64 image
                'jenis_mangga' => 'required|string',
            ]);

            // Save temporary image using helper
            $tempName = ImageHelper::base64ToWebp($request->image, 'scan/temp');
            $imageAbsolutePath = storage_path('app/public/' . $tempName);
            
            // Call FastAPI AI Server
            $response = \Illuminate\Support\Facades\Http::timeout(15)
                ->attach('image', file_get_contents($imageAbsolutePath), 'scan.webp')
                ->post('http://127.0.0.1:8001/api/scan', [
                    'jenis_mangga' => $request->jenis_mangga,
                ]);

            if ($response->failed()) {
                Storage::disk('public')->delete($tempName);
                throw new \Exception('Server AI (FastAPI) mengembalikan error.');
            }
            
            $result = $response->json();

            return response()->json([
                'status' => 'success',
                'data' => [
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
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'temp_path' => 'required|string',
                'jenis_mangga' => 'required|string',
                'berat_gram' => 'nullable|numeric',
                'diameter_cm' => 'nullable|numeric',
                'lahan_id' => 'nullable|exists:lahan,id',
                'results' => 'required|array'
            ]);

            $petani = Petani::where('pengguna_id', auth()->id())->first();
            if (!$petani) {
                throw new \Exception('Profil Petani tidak ditemukan. Harap lengkapi profil Anda.');
            }

            $tempPath = $request->temp_path;
            
            if (!Storage::disk('public')->exists($tempPath)) {
                return response()->json(['status' => 'error', 'message' => 'File tidak ditemukan.'], 404);
            }

            // Move to permanent
            $permanentPath = str_replace('temp/', '', $tempPath);
            Storage::disk('public')->move($tempPath, $permanentPath);

            $scan = ScanKesegaran::create([
                'petani_id' => $petani->id,
                'lahan_id' => $request->lahan_id,
                'path_foto' => $permanentPath,
                'berat_gram' => $request->berat_gram ?? $request->results['berat_gr'] ?? 0,
                'diameter_cm' => $request->diameter_cm ?? $request->results['panjang_cm'] ?? 0,
                'jenis_mangga' => $request->jenis_mangga,
                'skor_kesegaran' => $request->results['skor_kesegaran'],
                'persentase_warna' => $request->results['persentase_warna'],
                'skor_tekstur' => $request->results['skor_tekstur'],
                'skor_bentuk' => $request->results['skor_bentuk'] ?? null,
                'skor_aroma' => $request->results['skor_aroma'] ?? null,
                'kategori' => $request->results['kategori'],
                'rekomendasi' => $request->results['rekomendasi'],
                'skor_kepercayaan' => $request->results['skor_kepercayaan'],
                'batch_id' => 'BATCH-' . strtoupper(Str::random(8)),
                'dipindai_pada' => now(),
            ]);

            // Selalu buat ListingMangga (sebagai draft jika tidak langsung dipasarkan)
            if (!$request->lahan_id) {
                throw new \Exception('Harap pilih lahan produksi untuk menyimpan produk.');
            }

            $isPublish = $request->has('marketplace_data');

            \App\Models\ListingMangga::create([
                'petani_id' => $petani->id,
                'lahan_id' => $request->lahan_id,
                'scan_id' => $scan->id,
                'batch_id' => $scan->batch_id,
                'jenis_mangga' => $scan->jenis_mangga,
                'skor_kesegaran' => $scan->skor_kesegaran,
                'foto_batch' => [$scan->path_foto],
                'stok_tersedia_kg' => $isPublish ? ($request->marketplace_data['stok'] ?? 0) : 0,
                'harga_per_kg' => $isPublish ? ($request->marketplace_data['harga'] ?? 0) : 0,
                'minimal_order_kg' => $isPublish ? ($request->marketplace_data['min_order'] ?? 1) : 1,
                'deskripsi' => $isPublish ? ($request->marketplace_data['deskripsi'] ?? 'Mangga segar hasil scan AI.') : 'Draft produk hasil scan AI.',
                'aktif' => $isPublish,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => $isPublish ? 'Produk berhasil dipasarkan!' : 'Produk berhasil disimpan sebagai draft!',
                'scan_id' => $scan->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
