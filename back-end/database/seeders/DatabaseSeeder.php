<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Annonce;
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
            'password' => Hash::make('AdminPassword#2324'),
            'role' => 'root'
        ]);
        User::create([
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => 'test@localhost',
            'password' => Hash::make('UserPassword#2324'),
            'role' => 'client'
        ]);
        $this->call(MarqueSeeder::class);
        $this->call(ModeleSeeder::class);
        $this->call(CouleursSeeder::class);
        $this->call(VilleMaroc::class);
        Annonce::factory(60)->create();
    }
}
