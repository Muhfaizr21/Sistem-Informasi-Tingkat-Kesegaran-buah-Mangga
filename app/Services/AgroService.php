<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AgroService
{
    protected $apiKey;
    protected $baseUrl = 'http://api.agromonitoring.com/agro/1.0';

    public function __construct()
    {
        // Masukkan API Key Agromonitoring Anda di .env sebagai AGRO_API_KEY
        $this->apiKey = env('AGRO_API_KEY');
    }

    /**
     * Mendapatkan data NDVI (Vegetasi) terbaru untuk polygon tertentu
     */
    public function getNDVI($polygonId)
    {
        if (!$this->apiKey) return $this->mockNDVI();

        return Cache::remember("agro_ndvi_{$polygonId}", 3600 * 24, function () use ($polygonId) {
            $response = Http::get("{$this->baseUrl}/ndvi/history", [
                'polyid' => $polygonId,
                'start' => now()->subMonths(1)->timestamp,
                'end' => now()->timestamp,
                'appid' => $this->apiKey
            ]);

            return $response->json();
        });
    }

    /**
     * Mendapatkan data tanah (Soil Moisture & Temp)
     */
    public function getSoilData($polygonId)
    {
        if (!$this->apiKey) return $this->mockSoil();

        return Cache::remember("agro_soil_{$polygonId}", 3600, function () use ($polygonId) {
            $response = Http::get("{$this->baseUrl}/soil", [
                'polyid' => $polygonId,
                'appid' => $this->apiKey
            ]);

            return $response->json();
        });
    }

    /**
     * Simulasi data jika API Key belum dipasang agar UI tidak kosong
     */
    public function mockNDVI()
    {
        return [
            'dt' => now()->timestamp,
            'ndvi' => 0.74, // 0.7 - 0.9 berarti sangat sehat
            'std' => 0.05
        ];
    }

    public function mockSoil()
    {
        return [
            'dt' => now()->timestamp,
            't10' => 28.5, // Suhu tanah kedalaman 10cm
            'moisture' => 0.32, // 32% kelembaban
            't0' => 31.2 // Suhu permukaan
        ];
    }
}
