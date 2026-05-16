<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatistikWilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('dataset_baru_mangga_kuartal.csv');
        if (!file_exists($filePath)) return;

        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle); // skip header

        while (($data = fgetcsv($handle)) !== FALSE) {
            // no,kecamatan,produksi,luas_lahan,kuartal_per_bulan,tahun,jenis_mangga,cuaca,keberhasilan_panen
            $namaKecamatan = str_replace('Kecamatan ', '', $data[1]);
            $kecamatan = \App\Models\Kecamatan::where('nama', $namaKecamatan)->first();
            
            if ($kecamatan) {
                $tahun = $data[5];
                $produksiKuintal = floatval($data[2]) * 10; // Konversi Ton ke Kuintal
                $luasHektar = floatval($data[3]);

                // 1. Simpan ke Data Produksi Historis
                \App\Models\DataProduksiHistoris::updateOrCreate(
                    [
                        'kecamatan_id' => $kecamatan->id,
                        'tahun' => $tahun,
                        'kuartal' => $data[4],
                    ],
                    [
                        'produksi_kuintal' => $produksiKuintal,
                        'luas_hektar' => $luasHektar,
                        'jenis_mangga' => $data[6],
                        'cuaca' => $data[7],
                        'keberhasilan_panen' => $data[8],
                    ]
                );

                // 2. Simpan ke Data Lahan Historis
                \App\Models\DataLahanHistoris::updateOrCreate(
                    [
                        'kecamatan_id' => $kecamatan->id,
                        'tahun' => $tahun,
                    ],
                    [
                        'luas_hektar' => $luasHektar,
                    ]
                );

                // 3. Update Ringkasan Produksi (Untuk SEMUA Tahun)
                \App\Models\RingkasanProduksi::updateOrCreate(
                    [
                        'kecamatan_id' => $kecamatan->id,
                        'tahun' => $tahun,
                        'triwulan' => intval(substr($data[4], 1)), // Q1 -> 1
                    ],
                    [
                        'total_produksi_kuintal' => $produksiKuintal,
                        'total_lahan_hektar' => $luasHektar,
                        'sumber_data' => 'bps_csv',
                        'diperbarui_pada' => now(),
                    ]
                );

                // Juga buat record tahunan (triwulan = null)
                $totalTahunan = \App\Models\DataProduksiHistoris::where('kecamatan_id', $kecamatan->id)
                    ->where('tahun', $tahun)
                    ->sum('produksi_kuintal');

                \App\Models\RingkasanProduksi::updateOrCreate(
                    [
                        'kecamatan_id' => $kecamatan->id,
                        'tahun' => $tahun,
                        'triwulan' => null,
                    ],
                    [
                        'total_produksi_kuintal' => $totalTahunan,
                        'total_lahan_hektar' => $luasHektar,
                        'sumber_data' => 'bps_csv',
                        'diperbarui_pada' => now(),
                    ]
                );
            }
        }
        fclose($handle);
    }
}
