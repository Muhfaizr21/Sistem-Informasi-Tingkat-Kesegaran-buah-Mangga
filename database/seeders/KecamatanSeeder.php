<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatan = [
            ['kode_bps' => '3212010', 'nama' => 'Haurgeulis'],
            ['kode_bps' => '3212011', 'nama' => 'Gantar'],
            ['kode_bps' => '3212020', 'nama' => 'Kroya'],
            ['kode_bps' => '3212030', 'nama' => 'Gabuswetan'],
            ['kode_bps' => '3212040', 'nama' => 'Cikedung'],
            ['kode_bps' => '3212041', 'nama' => 'Terisi'],
            ['kode_bps' => '3212050', 'nama' => 'Lelea'],
            ['kode_bps' => '3212060', 'nama' => 'Bangodua'],
            ['kode_bps' => '3212061', 'nama' => 'Tukdana'],
            ['kode_bps' => '3212070', 'nama' => 'Widasari'],
            ['kode_bps' => '3212080', 'nama' => 'Kertasemaya'],
            ['kode_bps' => '3212081', 'nama' => 'Sukagumiwang'],
            ['kode_bps' => '3212090', 'nama' => 'Krangkeng'],
            ['kode_bps' => '3212100', 'nama' => 'Karangampel'],
            ['kode_bps' => '3212101', 'nama' => 'Kedokan Bunder'],
            ['kode_bps' => '3212110', 'nama' => 'Juntinyuat'],
            ['kode_bps' => '3212120', 'nama' => 'Sliyeg'],
            ['kode_bps' => '3212130', 'nama' => 'Jatibarang'],
            ['kode_bps' => '3212140', 'nama' => 'Balongan'],
            ['kode_bps' => '3212150', 'nama' => 'Indramayu'],
            ['kode_bps' => '3212160', 'nama' => 'Sindang'],
            ['kode_bps' => '3212161', 'nama' => 'Cantigi'],
            ['kode_bps' => '3212162', 'nama' => 'Pasekan'],
            ['kode_bps' => '3212170', 'nama' => 'Lohbener'],
            ['kode_bps' => '3212171', 'nama' => 'Arahan'],
            ['kode_bps' => '3212180', 'nama' => 'Losarang'],
            ['kode_bps' => '3212190', 'nama' => 'Kandanghaur'],
            ['kode_bps' => '3212200', 'nama' => 'Bongas'],
            ['kode_bps' => '3212210', 'nama' => 'Anjatan'],
            ['kode_bps' => '3212220', 'nama' => 'Sukra'],
            ['kode_bps' => '3212221', 'nama' => 'Patrol'],
            
            // Tambahan Wilayah Bandung (Untuk General/Testing)
            ['kode_bps' => '3273010', 'nama' => 'Sumur Bandung'],
            ['kode_bps' => '3273020', 'nama' => 'Bandung Wetan'],
            ['kode_bps' => '3273030', 'nama' => 'Coblong'],
            ['kode_bps' => '3273040', 'nama' => 'Cicendo'],
        ];

        foreach ($kecamatan as $k) {
            DB::table('kecamatan')->updateOrInsert(
                ['kode_bps' => $k['kode_bps']],
                ['nama' => $k['nama'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
