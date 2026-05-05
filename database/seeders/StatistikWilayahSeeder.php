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
        // Data Produksi 2024 (Triwulan & Tahunan)
        // Saya masukkan beberapa contoh data utama dari hasil analisis Excel sebelumnya
        $data = [
            // [Kode BPS, Tahun, Tw, Produksi Kuintal]
            ['3212010', 2024, 1, 0],
            ['3212010', 2024, 2, 57680],
            ['3212010', 2024, 3, 203949],
            ['3212010', 2024, 4, 242515],
            ['3212010', 2024, null, 504144], // Total 2024

            ['3212011', 2024, null, 12864],
            ['3212020', 2024, null, 19640],
            ['3212030', 2024, null, 9100],
            ['3212040', 2024, null, 106831],
            ['3212041', 2024, null, 12505],
            ['3212050', 2024, null, 59909],
            
            // Data 2025 (Prediksi/Berjalan)
            ['3212010', 2025, null, 309069],
            ['3212011', 2025, null, 492],
            ['3212020', 2025, null, 0],
            ['3212030', 2025, null, 400],
            ['3212040', 2025, null, 0],
        ];

        foreach ($data as $d) {
            $kecamatan = DB::table('kecamatan')->where('kode_bps', $d[0])->first();
            
            if ($kecamatan) {
                DB::table('ringkasan_produksi')->updateOrInsert(
                    [
                        'kecamatan_id' => $kecamatan->id,
                        'tahun' => $d[1],
                        'triwulan' => $d[2],
                    ],
                    [
                        'total_produksi_kuintal' => $d[3],
                        'sumber_data' => 'bps',
                        'diperbarui_pada' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
