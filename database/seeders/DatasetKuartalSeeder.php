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
        $filePath = base_path('dataset_kuartal.md');
        if (!file_exists($filePath)) {
            $this->command->error("File dataset_kuartal.md tidak ditemukan di: " . $filePath);
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $currentKecamatan = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // Match "1. KECAMATAN ANJATAN" or similar
            if (preg_match('/^\d+\.\s+KECAMATAN\s+(.+)$/i', $line, $matches)) {
                $namaKecamatan = trim($matches[1]);
                // Find matching Kecamatan case-insensitively
                $currentKecamatan = Kecamatan::where('nama', 'like', $namaKecamatan)->first();
                if (!$currentKecamatan) {
                    // Try without prefix or suffix just in case
                    $currentKecamatan = Kecamatan::whereRaw('LOWER(nama) = ?', [strtolower($namaKecamatan)])->first();
                }
                continue;
            }

            // Skip header lines
            if (str_contains($line, 'Tahun') && str_contains($line, 'Produksi')) {
                continue;
            }
            if (str_contains($line, 'RINGKASAN TOTAL') || str_contains($line, 'Catatan:')) {
                // We reached the summary or notes section
                $currentKecamatan = null;
                continue;
            }

            // Parse data rows like: 2011	80.62	2,391.42	Cengkir	Berangin	Kurang Panen
            if ($currentKecamatan) {
                $parts = preg_split('/\t+/', $line);
                if (count($parts) < 6) {
                    $parts = preg_split('/\s{2,}/', $line);
                }

                if (count($parts) >= 6 && preg_match('/^(20\d{2})$/', trim($parts[0]))) {
                    $tahun = intval(trim($parts[0]));
                    $produksiTon = floatval(str_replace(',', '', trim($parts[1])));
                    $luasHektar = floatval(str_replace(',', '', trim($parts[2])));
                    $jenisMangga = trim($parts[3]);
                    $cuaca = trim($parts[4]);
                    $keberhasilan = trim($parts[5]);

                    // Convert Ton to Kuintal for DB standard if needed (1 Ton = 10 Kuintal)
                    $produksiKuintal = $produksiTon * 10;

                    // Let's seed into data_produksi_historis
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
                }
            }
        }

        $this->command->info("Dataset Kuartal (Tahun 2011-2025) berhasil diimpor!");
    }
}
