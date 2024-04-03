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
            ['nom' => 'Toyota', 'image' => url('storage/assets/marques/toyota.png')],
            ['nom' => 'Honda', 'image' => url('storage/assets/marques/honda.png')],
            ['nom' => 'Ford', 'image' => url('storage/assets/marques/ford.png')],
            ['nom' => 'Chevrolet', 'image' =>   url('storage/assets/marques/chevrolet.png')],
            ['nom' => 'Volkswagen', 'image' => url('storage/assets/marques/volkswagen.png')],
            ['nom' => 'Nissan', 'image' => url('storage/assets/marques/nissan.png')],
            ['nom' => 'Hyundai', 'image' => url('storage/assets/marques/hyundai.png')],
            ['nom' => 'Mercedes-Benz', 'image' => url('storage/assets/marques/mercedes.png')],
            ['nom' => 'BMW', 'image' => url('storage/assets/marques/bmw.png')],
            ['nom' => 'Audi', 'image' => url('storage/assets/marques/audi.png')],
            ['nom' => 'Kia', 'image' => url('storage/assets/marques/kia.png')],
            ['nom' => 'Volvo', 'image' => url('storage/assets/marques/volvo.png')],
            ['nom' => 'Tesla', 'image' => url('storage/assets/marques/tesla.png')],
            ['nom' => 'Ferrari', 'image' => url('storage/assets/marques/ferrari.png')],
            ['nom' => 'Porsche', 'image' => url('storage/assets/marques/porsche.png')],
            ['nom' => 'Lamborghini', 'image' => url('storage/assets/marques/lamborghini.png')],
        ];
        foreach ($marques as $marque) {
            Marque::create([
                'nom' => $marque['nom'],
                'image' => $marque['image'],
            ]);
        }
    }
}
