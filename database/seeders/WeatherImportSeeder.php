<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeatherImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('dataset_baru_mangga_kuartal.csv');
        if (!file_exists($filePath)) return;

        $weatherMapping = [
            'Panas' => ['suhu_min' => 26, 'suhu_max' => 34, 'kelembaban' => 65, 'curah_hujan' => 0],
            'Hujan' => ['suhu_min' => 23, 'suhu_max' => 29, 'kelembaban' => 85, 'curah_hujan' => 20],
            'Hujan Ringan' => ['suhu_min' => 24, 'suhu_max' => 30, 'kelembaban' => 80, 'curah_hujan' => 5],
            'Cerah' => ['suhu_min' => 25, 'suhu_max' => 33, 'kelembaban' => 70, 'curah_hujan' => 0],
            'Cerah Berawan' => ['suhu_min' => 25, 'suhu_max' => 32, 'kelembaban' => 72, 'curah_hujan' => 0],
            'Berawan' => ['suhu_min' => 24, 'suhu_max' => 31, 'kelembaban' => 75, 'curah_hujan' => 0],
            'Berangin' => ['suhu_min' => 24, 'suhu_max' => 30, 'kelembaban' => 70, 'curah_hujan' => 0, 'kecepatan_angin' => 20],
            'Mendung' => ['suhu_min' => 23, 'suhu_max' => 29, 'kelembaban' => 80, 'curah_hujan' => 0],
        ];

        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle); // skip header

        while (($data = fgetcsv($handle)) !== FALSE) {
            // no,kecamatan,produksi,luas_lahan,kuartal_per_bulan,tahun,jenis_mangga,cuaca,keberhasilan_panen
            $namaKecamatan = str_replace('Kecamatan ', '', $data[1]);
            $kecamatan = \App\Models\Kecamatan::where('nama', $namaKecamatan)->first();
            
            if ($kecamatan) {
                $cuacaLabel = $data[7];
                $mapped = $weatherMapping[$cuacaLabel] ?? $weatherMapping['Cerah'];
                
                \App\Models\DataCuaca::create([
                    'kecamatan_id' => $kecamatan->id,
                    'latitude' => 0, // Fallback
                    'longitude' => 0, // Fallback
                    'tanggal_prakiraan' => \Carbon\Carbon::createFromDate($data[5], 1, 1)->toDateString(), // Fallback to Jan 1st of that year
                    'suhu_min' => $mapped['suhu_min'],
                    'suhu_max' => $mapped['suhu_max'],
                    'kelembaban' => $mapped['kelembaban'],
                    'curah_hujan_mm' => $mapped['curah_hujan'],
                    'kecepatan_angin' => $mapped['kecepatan_angin'] ?? 10,
                    'risiko_penyakit' => 'rendah',
                    'optimal_panen' => true,
                    'sumber_api' => 'CSV_IMPORT',
                    'diambil_pada' => now(),
                ]);
            }
        }
        fclose($handle);
    }
}
