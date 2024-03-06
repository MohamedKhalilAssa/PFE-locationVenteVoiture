<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\MarqueSeeder;
use Database\Seeders\ModeleSeeder;
use Database\Seeders\CouleursSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call(MarqueSeeder::class);
        $this->call(ModeleSeeder::class);
        $this->call(CouleursSeeder::class);
    }
}
