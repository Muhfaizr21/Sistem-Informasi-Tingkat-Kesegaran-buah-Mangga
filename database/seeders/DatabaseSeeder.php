<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        User::factory()->create([
            'name' => 'Admin Mango',
            'email' => 'admin@mango.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buyer Account
        User::factory()->create([
            'name' => 'Buyer Mango',
            'email' => 'buyer@mango.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);

        // Farmer Account
        User::factory()->create([
            'name' => 'Farmer Mango',
            'email' => 'farmer@mango.com',
            'password' => Hash::make('password'),
            'role' => 'farmer',
        ]);

        $this->call([
            ProductSeeder::class,
        ]);
    }
}
