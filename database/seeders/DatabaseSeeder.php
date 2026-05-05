<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        \App\Models\User::factory()->create([
            'name' => 'Admin Mango',
            'email' => 'admin@mango.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buyer Account
        \App\Models\User::factory()->create([
            'name' => 'Buyer Mango',
            'email' => 'buyer@mango.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'buyer',
        ]);

        // Petani Account
        \App\Models\User::factory()->create([
            'name' => 'Petani Mango',
            'email' => 'petani@mango.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'petani',
        ]);
    }
}
