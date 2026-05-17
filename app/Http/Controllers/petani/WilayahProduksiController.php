<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\Lahan;
use App\Models\LaporanPanen;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahProduksiController extends Controller
{
    public function index(\App\Services\AgroService $agroService)
    {
        $petani = Petani::where('pengguna_id', auth()->id())->first();
        $lahan = Lahan::where('petani_id', $petani->id ?? 0)
            ->with(['kecamatan'])
            ->get();

        // Geo-Analytics: Productivity per Lahan
        $stats = LaporanPanen::where('petani_id', $petani->id ?? 0)
            ->where('status', 'verified')
            ->select('lahan_id', DB::raw('SUM(jumlah_kg) as total_kg'))
            ->groupBy('lahan_id')
            ->get()
            ->pluck('total_kg', 'lahan_id');

        // Enhance lahan object with satellite agro data
        $lahanData = $lahan->map(function($item) use ($stats, $agroService) {
            $item->productivity = $stats[$item->id] ?? 0;
            
            // Satellite Monitoring (NDVI & Soil)
            $item->ndvi = $agroService->getNDVI('mock_poly_' . $item->id)['ndvi'] ?? 0.75;
            $item->soil_moisture = ($agroService->getSoilData('mock_poly_' . $item->id)['moisture'] ?? 0.32) * 100;
            
            return $item;
        });

        // Summary for Report from CSV Data
        $kecamatanIds = $lahan->pluck('kecamatan_id')->push($petani->kecamatan_id)->unique()->filter();
        
        $query = \App\Models\DataProduksiHistoris::whereIn('kecamatan_id', $kecamatanIds);

        if (request('search_tahun')) {
            $query->where('tahun', request('search_tahun'));
        }

        $historicalStats = $query->orderBy('tahun', 'desc')
            ->paginate(5)
            ->withQueryString();

        $latestYear = \App\Models\DataProduksiHistoris::where('kecamatan_id', $petani->kecamatan_id)
            ->orderBy('tahun', 'desc')
            ->first();
        
        $totalProduksi = $latestYear->produksi_kuintal ?? $stats->sum();
        $totalLuas = $latestYear->luas_hektar ?? $lahan->sum('luas_hektar');
        $avgProductivity = $totalLuas > 0 ? $totalProduksi / $totalLuas : 0;

        // Current Weather for the territory
        $currentWeather = \App\Models\DataCuaca::where('kecamatan_id', $petani->kecamatan_id)
            ->orderBy('tanggal_prakiraan', 'desc')
            ->first();

        return view('petani.wilayah-produksi', compact('lahanData', 'totalProduksi', 'totalLuas', 'avgProductivity', 'historicalStats', 'currentWeather'));
    }
}
