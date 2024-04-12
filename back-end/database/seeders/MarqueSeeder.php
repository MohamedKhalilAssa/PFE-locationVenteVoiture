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
            ['nom' => 'Chevrolet', 'image' =>   'assets/marques/chevrolet.svg'],
            ['nom' => 'Volkswagen', 'image' => 'assets/marques/volkswagen.svg'],
            ['nom' => 'Nissan', 'image' => 'assets/marques/nissan.svg'],
            ['nom' => 'Hyundai', 'image' => 'assets/marques/hyundai.svg'],
            ['nom' => 'Mercedes-Benz', 'image' => 'assets/marques/mercedes.svg'],
            ['nom' => 'Audi', 'image' => 'assets/marques/audi.svg'],
            ['nom' => 'Kia', 'image' => 'assets/marques/kia.svg'],
            ['nom' => 'Volvo', 'image' => 'assets/marques/volvo.svg'],
            ['nom' => 'Tesla', 'image' => 'assets/marques/tesla.svg'],
            ['nom' => 'Ferrari', 'image' => 'assets/marques/ferrari.svg'],
            ['nom' => 'Porsche', 'image' => 'assets/marques/porsche.svg'],
            ['nom' => 'Lamborghini', 'image' => 'assets/marques/lamborghini.svg'],
        ];
        foreach ($marques as $marque) {
            Marque::create([
                'nom' => $marque['nom'],
                'image' => $marque['image'],
            ]);
        }
    }
}
