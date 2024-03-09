<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\MarqueSeeder;
use Database\Seeders\ModeleSeeder;
use Database\Seeders\CouleursSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::create([
            'nom' => 'Super',
            'prenom' => 'Admin',
            'email' => 'admin@localhost',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
        $this->call(MarqueSeeder::class);
        $this->call(ModeleSeeder::class);
        $this->call(CouleursSeeder::class);
        $this->call(VilleMaroc::class);
    }
}
