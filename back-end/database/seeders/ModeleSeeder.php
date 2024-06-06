<?php

namespace Database\Seeders;

use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModeleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carModels = [
            ['nom' => 'Corolla', 'marque_id' => 1],
            ['nom' => 'Camry', 'marque_id' => 1],
            ['nom' => 'RAV4', 'marque_id' => 1],
            ['nom' => 'Highlander', 'marque_id' => 1],

            ['nom' => 'Civic', 'marque_id' => 2],
            ['nom' => 'Accord', 'marque_id' => 2],
            ['nom' => 'CR-V', 'marque_id' => 2],
            ['nom' => 'Pilot', 'marque_id' => 2],

            ['nom' => 'F-150', 'marque_id' => 3],
            ['nom' => 'Mustang', 'marque_id' => 3],
            ['nom' => 'Escape', 'marque_id' => 3],
            ['nom' => 'Explorer', 'marque_id' => 3],

            ['nom' => 'A3', 'marque_id' => 4],
            ['nom' => 'A4', 'marque_id' => 4],
            ['nom' => 'Q5', 'marque_id' => 4],
            ['nom' => 'Q7', 'marque_id' => 4],

            ['nom' => 'Golf', 'marque_id' => 5],
            ['nom' => 'Passat', 'marque_id' => 5],
            ['nom' => 'Tiguan', 'marque_id' => 5],
            ['nom' => 'Atlas', 'marque_id' => 5],

            ['nom' => 'Altima', 'marque_id' => 6],
            ['nom' => 'Sentra', 'marque_id' => 6],
            ['nom' => 'Rogue', 'marque_id' => 6],
            ['nom' => 'Murano', 'marque_id' => 6],

            ['nom' => 'Elantra', 'marque_id' => 7],
            ['nom' => 'Sonata', 'marque_id' => 7],
            ['nom' => 'Tucson', 'marque_id' => 7],
            ['nom' => 'Santa Fe', 'marque_id' => 7],

            ['nom' => 'C-Class', 'marque_id' => 8],
            ['nom' => 'E-Class', 'marque_id' => 8],
            ['nom' => 'GLC', 'marque_id' => 8],
            ['nom' => 'GLE', 'marque_id' => 8],




        ];
        foreach ($carModels as $model) {
            Modele::create($model);
        }
    }
}
