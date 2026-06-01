<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ListingMangga;
use App\Models\LaporanPanen;
use App\Models\Petani;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KecamatanSeeder::class,
            KategoriManggaSeeder::class,
            TestUserSeeder::class,
            StatistikWilayahSeeder::class,
            WeatherImportSeeder::class,
            DatasetKuartalSeeder::class,
            SystemSettingSeeder::class,
        ]);

        // Akun Admin Default
        User::updateOrCreate(
            ['email' => 'admin@mangga.com'],
            [
                'nama' => 'Administrator Utama',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Akun Petani Contoh
        User::updateOrCreate(
            ['email' => 'petani@mangga.com'],
            [
                'nama' => 'Bpk. Ahmad Suganda',
                'password' => Hash::make('petani123'),
                'role' => 'petani',
            ]
        );

        // Akun Pembeli Contoh
        $userPembeli = User::updateOrCreate(
            ['email' => 'pembeli@mangga.com'],
            [
                'nama' => 'Ibu Siti Aminah',
                'password' => Hash::make('pembeli123'),
                'role' => 'pembeli',
            ]
        );

        \DB::table('pembeli')->updateOrInsert(
            ['pengguna_id' => $userPembeli->id],
            [
                'tipe_bisnis' => 'individu',
                'poin_loyalitas' => 150,
                'tier_member' => 'silver',
            ]
        );

        // Profil Petani & Lahan are seeded inside the petani check below
        $petani = User::where('email', 'petani@mangga.com')->first();
        if ($petani) {

            // Seed Profil Petani
            $petaniProfile = Petani::updateOrCreate(
                ['pengguna_id' => $petani->id],
                [
                    'nik' => '3212012345678901',
                    'pengalaman_tahun' => 10,
                    'kelompok_tani' => 'Mekar Sari Indramayu',
                    'status_verifikasi' => 'verified',
                ]
            );

            // Seed Lahan
            $lahanId = DB::table('lahan')->updateOrInsert(
                ['petani_id' => $petaniProfile->id, 'nama_lahan' => 'Kebun Mangga Blok Utama'],
                [
                    'latitude' => -6.3276,
                    'longitude' => 108.3249,
                    'kecamatan_id' => 1,
                    'desa' => 'Karangsong',
                    'luas_hektar' => 2.5,
                    'jenis_mangga' => 'Harum Manis',
                    'jumlah_pohon' => 150,
                    'tahun_tanam' => 2018,
                    'status' => 'produktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            
            $lahan = DB::table('lahan')->where('petani_id', $petaniProfile->id)->first();

            // Seed Laporan Panen Contoh
            LaporanPanen::updateOrCreate(
                ['petani_id' => $petaniProfile->id, 'lahan_id' => $lahan->id, 'tanggal_panen' => now()->subDays(5)->toDateString()],
                [
                    'jumlah_kg' => 450.5,
                    'jenis_mangga' => 'Harum Manis',
                    'catatan' => 'Panen pagi hari, cuaca cerah.',
                    'status' => 'verified',
                ]
            );

            // Seed Marketplace Listing
            ListingMangga::updateOrCreate(
                ['petani_id' => $petaniProfile->id, 'jenis_mangga' => 'Harum Manis Super'],
                [
                    'lahan_id' => $lahan->id,
                    'stok_tersedia_kg' => 150.00,
                    'harga_per_kg' => 25000,
                    'deskripsi' => 'Mangga Harum Manis kualitas ekspor langsung dari kebun.',
                    'aktif' => true,
                    'foto_batch' => ['https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=800&q=80'],
                ]
            );

            ListingMangga::updateOrCreate(
                ['petani_id' => $petaniProfile->id, 'jenis_mangga' => 'Gedong Gincu'],
                [
                    'lahan_id' => $lahan->id,
                    'stok_tersedia_kg' => 85.00,
                    'harga_per_kg' => 35000,
                    'deskripsi' => 'Gedong Gincu khas Indramayu dengan aroma yang sangat harum.',
                    'aktif' => true,
                    'foto_batch' => ['https://images.unsplash.com/photo-1591073113125-e46713c829ed?auto=format&fit=crop&w=800&q=80'],
                ]
            );


            // Seed Data Cuaca (untuk Rekomendasi)
            DB::table('data_cuaca')->updateOrInsert(
                ['kecamatan_id' => 1, 'tanggal_prakiraan' => Carbon::today()->toDateString()],
                [
                    'latitude' => -6.3276,
                    'longitude' => 108.3249,
                    'suhu_min' => 24.5,
                    'suhu_max' => 32.0,
                    'kelembaban' => 75.0,
                    'curah_hujan_mm' => 5.2,
                    'kecepatan_angin' => 12.0,
                    'risiko_penyakit' => 'rendah',
                    'optimal_panen' => true,
                    'sumber_api' => 'OpenWeather',
                    'diambil_pada' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Seed ScanKesegaran records for the last 7 days to populate the trend analysis curve
            $now = Carbon::now();
            $scanData = [
                ['days_ago' => 6, 'score' => 88.5, 'confidence' => 92.0, 'jenis' => 'Harum Manis', 'anomaly' => false, 'foto' => 'scan/B2OZg1koyQ_1778080280.webp'],
                ['days_ago' => 5, 'score' => 77.8, 'confidence' => 88.0, 'jenis' => 'Harum Manis', 'anomaly' => false, 'foto' => 'scan/CvnECsbRYC_1778080309.webp'],
                ['days_ago' => 4, 'score' => 82.3, 'confidence' => 90.5, 'jenis' => 'Gedong Gincu', 'anomaly' => false, 'foto' => 'scan/FjXoH9ixK9_1778080329.webp'],
                ['days_ago' => 3, 'score' => 48.4, 'confidence' => 45.0, 'jenis' => 'Harum Manis', 'anomaly' => true, 'verifikasi' => 'rejected', 'foto' => 'scan/KfO7ebYj0i_1778154185.webp'], // Anomaly (Low score, rejected)
                ['days_ago' => 2, 'score' => 89.1, 'confidence' => 94.0, 'jenis' => 'Gedong Gincu', 'anomaly' => false, 'foto' => 'scan/YHl789wX3S_1778138023.webp'],
                ['days_ago' => 1, 'score' => 79.5, 'confidence' => 58.0, 'jenis' => 'Indramayu', 'anomaly' => true, 'foto' => 'scan/aEpJqVEO70_1778148805.webp'], // Anomaly (Low confidence)
                ['days_ago' => 0, 'score' => 84.2, 'confidence' => 91.0, 'jenis' => 'Harum Manis', 'anomaly' => false, 'foto' => 'scan/hojJhkSwWl_1778246255.webp'],
            ];

            foreach ($scanData as $s) {
                $scanDate = (clone $now)->subDays($s['days_ago']);
                
                $createdScan = \App\Models\ScanKesegaran::updateOrCreate(
                    ['path_foto' => $s['foto']],
                    [
                        'petani_id' => $petaniProfile->id,
                        'lahan_id' => $lahan->id,
                        'berat_gram' => rand(300, 500),
                        'diameter_cm' => rand(8, 12),
                        'jenis_mangga' => $s['jenis'],
                        'skor_kesegaran' => $s['score'],
                        'persentase_warna' => rand(60, 85),
                        'skor_tekstur' => rand(70, 90),
                        'skor_bentuk' => rand(75, 95),
                        'skor_aroma' => rand(70, 90),
                        'kategori' => $s['score'] >= 90 ? 'matang' : ($s['score'] >= 80 ? 'sangat_matang' : ($s['score'] >= 70 ? 'setengah_matang' : 'mentah')),
                        'rekomendasi' => $s['score'] >= 80 ? 'siap_jual' : ($s['score'] >= 70 ? 'perlu_penyimpanan' : 'belum_siap'),
                        'skor_kepercayaan' => $s['confidence'],
                        'batch_id' => 'BATCH-' . strtoupper(\Illuminate\Support\Str::random(8)),
                        'dipindai_pada' => $scanDate,
                        'status_verifikasi' => $s['verifikasi'] ?? 'pending',
                        'is_anomaly' => $s['anomaly'],
                        'created_at' => $scanDate,
                        'updated_at' => $scanDate,
                    ]
                );

                // Create a sample draft listing matching this batch if not already exists
                ListingMangga::updateOrCreate(
                    ['scan_id' => $createdScan->id],
                    [
                        'petani_id' => $petaniProfile->id,
                        'lahan_id' => $lahan->id,
                        'batch_id' => $createdScan->batch_id,
                        'jenis_mangga' => $createdScan->jenis_mangga,
                        'skor_kesegaran' => $createdScan->skor_kesegaran,
                        'foto_batch' => [$createdScan->path_foto],
                        'stok_tersedia_kg' => 0,
                        'harga_per_kg' => 0,
                        'minimal_order_kg' => 1,
                        'deskripsi' => 'Draft produk hasil scan AI.',
                        'aktif' => false,
                    ]
                );
            }
        }
    }
}
