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
        }
    }
}
