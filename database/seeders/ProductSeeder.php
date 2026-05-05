<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'Mangga Harum Manis Super',
            'variety' => 'Harum Manis',
            'price' => 25000,
            'stock' => 100,
            'grade' => 'Grade A+',
            'description' => 'Mangga manis dengan tekstur daging yang lembut.',
            'image' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=400&q=80',
        ]);

        \App\Models\Product::create([
            'name' => 'Gedong Gincu Pilihan',
            'variety' => 'Gedong Gincu',
            'price' => 35000,
            'stock' => 50,
            'grade' => 'Grade A',
            'description' => 'Mangga eksotis dengan aroma yang sangat wangi.',
            'image' => 'https://images.unsplash.com/photo-1591073113125-e46713c829ed?auto=format&fit=crop&w=400&q=80',
        ]);
    }
}
