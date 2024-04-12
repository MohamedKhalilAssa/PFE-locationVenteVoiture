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
            ['nom' => 'Toyota', 'image' => url('storage/assets/marques/toyota.svg')],
            ['nom' => 'Honda', 'image' => url('storage/assets/marques/honda.svg')],
            ['nom' => 'Ford', 'image' => url('storage/assets/marques/ford.svg')],
            ['nom' => 'Chevrolet', 'image' =>   url('storage/assets/marques/chevrolet.svg')],
            ['nom' => 'Volkswagen', 'image' => url('storage/assets/marques/volkswagen.svg')],
            ['nom' => 'Nissan', 'image' => url('storage/assets/marques/nissan.svg')],
            ['nom' => 'Hyundai', 'image' => url('storage/assets/marques/hyundai.svg')],
            ['nom' => 'Mercedes-Benz', 'image' => url('storage/assets/marques/mercedes.svg')],
            ['nom' => 'Audi', 'image' => url('storage/assets/marques/audi.svg')],
            ['nom' => 'Kia', 'image' => url('storage/assets/marques/kia.svg')],
            ['nom' => 'Volvo', 'image' => url('storage/assets/marques/volvo.svg')],
            ['nom' => 'Tesla', 'image' => url('storage/assets/marques/tesla.svg')],
            ['nom' => 'Ferrari', 'image' => url('storage/assets/marques/ferrari.svg')],
            ['nom' => 'Porsche', 'image' => url('storage/assets/marques/porsche.svg')],
            ['nom' => 'Lamborghini', 'image' => url('storage/assets/marques/lamborghini.svg')],
        ];
        foreach ($marques as $marque) {
            Marque::create([
                'nom' => $marque['nom'],
                'image' => $marque['image'],
            ]);
        }
    }
}
