<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriManggaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama' => 'Harum Manis', 'deskripsi' => 'Mangga dengan aroma harum dan rasa manis yang khas.'],
            ['nama' => 'Gedong Gincu', 'deskripsi' => 'Mangga berwarna kemerahan dengan rasa manis sedikit asam.'],
            ['nama' => 'Cengkir', 'deskripsi' => 'Mangga dengan tekstur daging buah yang renyah.'],
            ['nama' => 'Manalagi', 'deskripsi' => 'Mangga dengan rasa manis yang konsisten walau belum terlalu matang.'],
        ];

        foreach ($categories as $category) {
            \App\Models\KategoriMangga::updateOrCreate(
                ['nama' => $category['nama']],
                ['deskripsi' => $category['deskripsi']]
            );
        }
    }
}
