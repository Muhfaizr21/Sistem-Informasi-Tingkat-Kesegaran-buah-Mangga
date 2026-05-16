<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatans = \App\Models\Kecamatan::all();

        foreach ($kecamatans as $kecamatan) {
            $slug = strtolower(str_replace(' ', '_', $kecamatan->nama));
            $email = "petani.{$slug}@mangga.com";

            $user = \App\Models\User::updateOrCreate(
                ['email' => $email],
                [
                    'nama' => "Petani " . $kecamatan->nama,
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'role' => 'petani',
                ]
            );

            \App\Models\Petani::updateOrCreate(
                ['pengguna_id' => $user->id],
                [
                    'kecamatan_id' => $kecamatan->id,
                    'status_verifikasi' => 'verified',
                    'nik' => '3212' . str_pad($kecamatan->id, 12, '0', STR_PAD_LEFT),
                ]
            );
        }
    }
}
