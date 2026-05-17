<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kecamatan;
use App\Models\DataProduksiHistoris;

class DatasetKuartalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Parse rich metadata columns from dataset_kuartal.md if it exists
        $richData = [];
        $kuartalPath = base_path('dataset_kuartal.md');
        if (file_exists($kuartalPath)) {
            $kLines = file($kuartalPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $currKec = null;
            foreach ($kLines as $kLine) {
                $kLine = trim($kLine);
                if (preg_match('/^\d+\.\s+KECAMATAN\s+(.+)$/i', $kLine, $matches)) {
                    $currKec = strtolower(trim(str_replace('Kecamatan ', '', $matches[1])));
                    continue;
                }
                if ($currKec && !str_contains($kLine, 'Tahun') && !str_contains($kLine, 'RINGKASAN')) {
                    $parts = preg_split('/\t+/', $kLine);
                    if (count($parts) < 6) {
                        $parts = preg_split('/\s{2,}/', $kLine);
                    }
                    if (count($parts) >= 6 && preg_match('/^(20\d{2})$/', trim($parts[0]))) {
                        $yr = intval(trim($parts[0]));
                        $richData["$currKec:$yr"] = [
                            'jenis_mangga' => trim($parts[3]),
                            'cuaca' => trim($parts[4]),
                            'keberhasilan' => trim($parts[5]),
                        ];
                    }
                }
            }
        }

        // 2. Read the flat numerical data from dataset_prediksi.md
        $predPath = base_path('dataset_prediksi.md');
        if (!file_exists($predPath)) {
            $this->command->error("File dataset_prediksi.md tidak ditemukan di: " . $predPath);
            return;
        }

        $lines = file($predPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            // Skip header
            if (str_contains($line, 'kecamatan') && str_contains($line, 'produksi')) {
                continue;
            }

            $parts = preg_split('/\t+/', $line);
            if (count($parts) < 5) {
                $parts = preg_split('/\s{2,}/', $line);
            }

            if (count($parts) >= 5) {
                $rawKecamatan = trim($parts[1]);
                $namaKecamatan = trim(str_replace('Kecamatan ', '', $rawKecamatan));
                
                // Parse float using comma to dot conversion (e.g. 80,62 -> 80.62)
                $produksiTon = floatval(str_replace(',', '.', trim($parts[2])));
                $luasHektar = floatval(str_replace(',', '.', trim($parts[3])));
                $tahun = intval(trim($parts[4]));

                // Find matching Kecamatan case-insensitively
                $currentKecamatan = Kecamatan::whereRaw('LOWER(nama) = ?', [strtolower($namaKecamatan)])->first();
                if ($currentKecamatan) {
                    $key = strtolower($namaKecamatan) . ":$tahun";
                    $jenisMangga = $richData[$key]['jenis_mangga'] ?? 'Harum Manis';
                    $cuaca = $richData[$key]['cuaca'] ?? 'Cerah';
                    $keberhasilan = $richData[$key]['keberhasilan'] ?? 'Berhasil Panen';

                    // Convert Ton to Kuintal for DB standard (1 Ton = 10 Kuintal)
                    $produksiKuintal = $produksiTon * 10;

                    // 1. Seed Annual/Yearly Record (TA)
                    DataProduksiHistoris::updateOrCreate(
                        [
                            'kecamatan_id' => $currentKecamatan->id,
                            'tahun' => $tahun,
                            'kuartal' => 'TA', // 'TA' for Tahunan/Yearly
                        ],
                        [
                            'produksi_kuintal' => $produksiKuintal,
                            'luas_hektar' => $luasHektar,
                            'jenis_mangga' => $jenisMangga,
                            'cuaca' => $cuaca,
                            'keberhasilan_panen' => $keberhasilan,
                        ]
                    );

                    // Seed Ringkasan Produksi for Annual (triwulan = null)
                    \App\Models\RingkasanProduksi::updateOrCreate(
                        [
                            'kecamatan_id' => $currentKecamatan->id,
                            'tahun' => $tahun,
                            'triwulan' => null,
                        ],
                        [
                            'total_produksi_kuintal' => $produksiKuintal,
                            'total_lahan_hektar' => $luasHektar,
                            'sumber_data' => 'bps_markdown',
                            'diperbarui_pada' => now(),
                        ]
                    );

                    // 2. Seed Quarterly Records (Q1 - Q4) for comprehensive seasonal analytics
                    $quarters = [
                        'Q1' => [
                            'pct' => 0.05,
                            'cuaca' => 'Hujan',
                            'keberhasilan' => $keberhasilan === 'Berhasil Panen' ? 'Kurang Panen' : 'Tidak Berhasil',
                        ],
                        'Q2' => [
                            'pct' => 0.15,
                            'cuaca' => 'Cerah Berawan',
                            'keberhasilan' => $keberhasilan === 'Berhasil Panen' ? 'Berhasil Panen' : 'Kurang Panen',
                        ],
                        'Q3' => [
                            'pct' => 0.45,
                            'cuaca' => 'Cerah',
                            'keberhasilan' => $keberhasilan === 'Tidak Berhasil' ? 'Kurang Panen' : 'Berhasil Panen',
                        ],
                        'Q4' => [
                            'pct' => 0.35,
                            'cuaca' => 'Cerah Berawan',
                            'keberhasilan' => $keberhasilan === 'Berhasil Panen' ? 'Berhasil Panen' : 'Kurang Panen',
                        ],
                    ];

                    foreach ($quarters as $qKey => $qData) {
                        $qProduksiKuintal = $produksiKuintal * $qData['pct'];

                        DataProduksiHistoris::updateOrCreate(
                            [
                                'kecamatan_id' => $currentKecamatan->id,
                                'tahun' => $tahun,
                                'kuartal' => $qKey,
                            ],
                            [
                                'produksi_kuintal' => $qProduksiKuintal,
                                'luas_hektar' => $luasHektar,
                                'jenis_mangga' => $jenisMangga,
                                'cuaca' => $qData['cuaca'],
                                'keberhasilan_panen' => $qData['keberhasilan'],
                            ]
                        );

                        // Also seed into ringkasan_produksi for each quarter (triwulan 1-4)
                        \App\Models\RingkasanProduksi::updateOrCreate(
                            [
                                'kecamatan_id' => $currentKecamatan->id,
                                'tahun' => $tahun,
                                'triwulan' => intval(substr($qKey, 1)), // Q1 -> 1
                            ],
                            [
                                'total_produksi_kuintal' => $qProduksiKuintal,
                                'total_lahan_hektar' => $luasHektar,
                                'sumber_data' => 'bps_markdown',
                                'diperbarui_pada' => now(),
                            ]
                        );
                    }
                }
            }
        }

        $this->command->info("Dataset Prediksi & Kuartal (Tahun 2011-2025) berhasil diimpor!");
    }
}
