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
            'Toyota',
            'Honda',
            'Ford',
            'Chevrolet',
            'Volkswagen',
            'Nissan',
            'Hyundai',
            'Mercedes-Benz',
            'BMW',
            'Audi',
            'Kia',
            'Volvo',
            'Subaru',
            'Mazda',
            'Lexus',
            'Jeep',
            'Tesla',
            'Ferrari',
            'Porsche',
            'Lamborghini',
        ];
        foreach ($marques as $marque) {
            Marque::create([
                'nom' => $marque,
            ]);
        }
    }
}
