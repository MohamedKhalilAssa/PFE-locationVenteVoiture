<?php

namespace Database\Seeders;

use App\Models\Marque;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MarqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marques = [
            ['nom' => 'Toyota', 'image' => 'assets/marques/toyota.svg'],
            ['nom' => 'Honda', 'image' => 'assets/marques/honda.svg'],
            ['nom' => 'Ford', 'image' => 'assets/marques/ford.svg'],
            ['nom' => 'Audi', 'image' => 'assets/marques/audi.svg'],
            ['nom' => 'Volkswagen', 'image' => 'assets/marques/volkswagen.svg'],
            ['nom' => 'Nissan', 'image' => 'assets/marques/nissan.svg'],
            ['nom' => 'Hyundai', 'image' => 'assets/marques/hyundai.svg'],
            ['nom' => 'Mercedes-Benz', 'image' => 'assets/marques/mercedes.svg'],

        ];
        foreach ($marques as $marque) {
            Marque::create([
                'nom' => $marque['nom'],
                'image' => $marque['image'],
            ]);
        }
    }
}
