<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\DataCuaca;
use Carbon\Carbon;

class WeatherService
{
    public function getForecast($lat = -6.3276, $lon = 108.3249)
    {
        $cacheKey = "weather_forecast_v4_{$lat}_{$lon}";

        return Cache::remember($cacheKey, 3600, function () use ($lat, $lon) {
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $lat,
                'longitude' => $lon,
                'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_sum,precipitation_probability_max,relative_humidity_2m_max,wind_speed_10m_max,uv_index_max,shortwave_radiation_sum',
                'hourly' => 'weather_code,temperature_2m,precipitation',
                'timezone' => 'Asia/Jakarta',
                'forecast_days' => 14
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $hourlyData = $data['hourly'] ?? [];
                $forecast = [];
                
                foreach ($data['daily']['time'] as $index => $time) {
                    $rain = $data['daily']['precipitation_sum'][$index];
                    $prob = $data['daily']['precipitation_probability_max'][$index] ?? 0;
                    $wCode = $data['daily']['weather_code'][$index];
                    $maxTemp = $data['daily']['temperature_2m_max'][$index];
                    $humidity = $data['daily']['relative_humidity_2m_max'][$index] ?? 75;

                    // Map WMO Code to Text & Icon
                    $condition = $this->mapWmoCode($wCode);

                    // Extract 24 hours for this day
                    $dayHourly = [];
                    if (!empty($hourlyData)) {
                        $startIndex = $index * 24;
                        for ($h = 0; $h < 24; $h++) {
                            $idx = $startIndex + $h;
                            if (isset($hourlyData['time'][$idx])) {
                                $dayHourly[] = [
                                    'time' => Carbon::parse($hourlyData['time'][$idx])->format('H:i'),
                                    'temp' => $hourlyData['temperature_2m'][$idx],
                                    'rain' => $hourlyData['precipitation'][$idx],
                                    'condition' => $this->mapWmoCode($hourlyData['weather_code'][$idx])
                                ];
                            }
                        }
                    }

                    // Logic Rekomendasi
                    $isOptimal = ($rain < 0.5 && $maxTemp <= 32 && $maxTemp >= 20 && $humidity <= 85);

                    // Trigger Notifikasi jika hujan lebat (> 10mm)
                    if ($rain > 10 && Auth::check()) {
                        \App\Models\Notifikasi::updateOrCreate(
                            [
                                'pengguna_id' => Auth::id(),
                                'judul' => 'Peringatan Hujan Lebat! ⛈️',
                                'pesan' => "Prediksi hujan mencapai {$rain}mm pada tanggal " . Carbon::parse($time)->format('d M') . ". Persiapkan perlindungan lahan.",
                                'referensi_tipe' => 'cuaca',
                                'referensi_id' => $index
                            ],
                            [
                                'tipe' => 'warning',
                                'sudah_dibaca' => false,
                            ]
                        );
                    }

                    $weatherObj = (object)[
                        'tanggal_prakiraan' => $time,
                        'suhu_max' => $maxTemp,
                        'suhu_min' => $data['daily']['temperature_2m_min'][$index],
                        'curah_hujan_mm' => $rain,
                        'peluang_hujan' => $prob,
                        'weather_code' => $wCode,
                        'kondisi' => $condition['text'],
                        'icon' => $condition['icon'],
                        'color' => $condition['color'],
                        'uv_index' => $data['daily']['uv_index_max'][$index] ?? 0,
                        'radiation' => $data['daily']['shortwave_radiation_sum'][$index] ?? 0,
                        'kelembaban' => $humidity,
                        'kecepatan_angin' => $data['daily']['wind_speed_10m_max'][$index],
                        'optimal_panen' => $isOptimal,
                        'hourly' => $dayHourly,
                        'sumber_api' => 'Open-Meteo',
                    ];

                    // Sync to Database for Big Data Analytics
                    DataCuaca::updateOrCreate(
                        [
                            'latitude' => round($lat, 4),
                            'longitude' => round($lon, 4),
                            'tanggal_prakiraan' => $time,
                        ],
                        [
                            'suhu_max' => $maxTemp,
                            'suhu_min' => $data['daily']['temperature_2m_min'][$index],
                            'curah_hujan_mm' => $rain,
                            'kelembaban' => $humidity,
                            'kecepatan_angin' => $data['daily']['wind_speed_10m_max'][$index],
                            'optimal_panen' => $isOptimal,
                            'sumber_api' => 'Open-Meteo',
                            'diambil_pada' => now(),
                        ]
                    );

                    $forecast[] = $weatherObj;
                }
                return collect($forecast);
            }

            return collect();
        });
    }

    /**
     * Map WMO Weather Codes to Human-Readable Format
     * Based on: https://open-meteo.com/en/docs
     */
    private function mapWmoCode($code)
    {
        $map = [
            0 => ['text' => 'Cerah', 'icon' => 'sunny', 'color' => 'text-yellow-500'],
            1 => ['text' => 'Cerah Berawan', 'icon' => 'partly_cloudy_day', 'color' => 'text-yellow-400'],
            2 => ['text' => 'Berawan', 'icon' => 'cloud', 'color' => 'text-slate-400'],
            3 => ['text' => 'Mendung', 'icon' => 'cloudy', 'color' => 'text-slate-500'],
            45 => ['text' => 'Kabut', 'icon' => 'foggy', 'color' => 'text-slate-300'],
            48 => ['text' => 'Kabut Berembun', 'icon' => 'foggy', 'color' => 'text-slate-300'],
            51 => ['text' => 'Gerimis Ringan', 'icon' => 'grain', 'color' => 'text-blue-300'],
            53 => ['text' => 'Gerimis Sedang', 'icon' => 'grain', 'color' => 'text-blue-400'],
            55 => ['text' => 'Gerimis Lebat', 'icon' => 'grain', 'color' => 'text-blue-500'],
            61 => ['text' => 'Hujan Ringan', 'icon' => 'rainy', 'color' => 'text-blue-300'],
            63 => ['text' => 'Hujan Sedang', 'icon' => 'rainy', 'color' => 'text-blue-400'],
            65 => ['text' => 'Hujan Lebat', 'icon' => 'rainy_heavy', 'color' => 'text-blue-600'],
            80 => ['text' => 'Hujan Showers', 'icon' => 'rainy', 'color' => 'text-blue-400'],
            81 => ['text' => 'Hujan Showers Sedang', 'icon' => 'rainy', 'color' => 'text-blue-500'],
            82 => ['text' => 'Hujan Showers Lebat', 'icon' => 'rainy_heavy', 'color' => 'text-blue-600'],
            95 => ['text' => 'Badai Guntur', 'icon' => 'thunderstorm', 'color' => 'text-indigo-500'],
            96 => ['text' => 'Badai Guntur & Hujan Es', 'icon' => 'thunderstorm', 'color' => 'text-indigo-600'],
            99 => ['text' => 'Badai Guntur Hebat', 'icon' => 'thunderstorm', 'color' => 'text-indigo-700'],
        ];

        return $map[$code] ?? ['text' => 'Tidak Diketahui', 'icon' => 'help', 'color' => 'text-slate-400'];
    }

    /**
     * Get current weather for dashboard
     */
    public function getCurrentWeather($lat = -6.3276, $lon = 108.3249)
    {
        $forecast = $this->getForecast($lat, $lon);
        return $forecast->first() ?? null;
    }
}
