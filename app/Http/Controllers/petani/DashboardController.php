<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LaporanPanen;

class DashboardController extends Controller
{
    public function index(\App\Services\WeatherService $weatherService, \App\Services\AgroService $agroService)
    {
        $userId = auth()->id();
        $petani = DB::table('petani')->where('pengguna_id', $userId)->first();
        
        // Ringkasan Lahan
        $lahan = collect();
        if ($petani) {
            $lahan = DB::table('lahan')->where('petani_id', $petani->id)->get();
        }
        
        $totalHektar = $lahan->sum('luas_hektar');
        $varietas = $lahan->pluck('jenis_mangga')->unique()->values()->all();
        $statusLahan = $lahan->groupBy('status')->map->count();

        // Statistik Panen
        $thisMonth = Carbon::now()->startOfMonth();
        $reports = collect();
        if ($petani) {
            $reports = LaporanPanen::where('petani_id', $petani->id)
                ->where('created_at', '>=', $thisMonth)
                ->get();
        }
        
        $totalPanenBulanIni = $reports->sum('jumlah_kg');
        $rataRataKualitas = 85.5; 

        // Status Penjualan
        $listing = collect();
        if ($petani) {
            $listing = DB::table('listing_mangga')->where('petani_id', $petani->id)->get();
        }
        $manggaTersedia = $listing->sum('stok_tersedia_kg');
        $manggaTerjual = 0; 
        $pendapatanBulanIni = 0; 

        // Live Weather based on Primary Land
        $lahanUtama = $lahan->first();
        $cuaca = $weatherService->getCurrentWeather(
            $lahanUtama->latitude ?? -6.3276, 
            $lahanUtama->longitude ?? 108.3249
        );

        // Agro Data (Satellite Monitoring)
        $agroData = [
            'ndvi' => $agroService->getNDVI('mock_poly_id'),
            'soil' => $agroService->getSoilData('mock_poly_id')
        ];

        return view('petani.dashboard', compact(
            'totalHektar', 'varietas', 'statusLahan', 'lahan',
            'totalPanenBulanIni', 'rataRataKualitas',
            'manggaTersedia', 'manggaTerjual', 'pendapatanBulanIni',
            'cuaca', 'agroData'
        ));
    }
}
