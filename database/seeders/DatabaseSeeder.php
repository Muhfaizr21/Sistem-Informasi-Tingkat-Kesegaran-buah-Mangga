<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KecamatanSeeder::class,
            StatistikWilayahSeeder::class,
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
        User::updateOrCreate(
            ['email' => 'pembeli@mangga.com'],
            [
                'nama' => 'Ibu Siti Aminah',
                'password' => Hash::make('pembeli123'),
                'role' => 'pembeli',
            ]
        );
    }
}
