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
        Marque::all()->each(function ($marque) {

            // Create Modeles for the current Marque
            for ($i = 1; $i <= 3; $i++) { // Creating 3 models for each Marque
                Modele::create([
                    'nom' => $marque['nom'] . ' Model ' . $i,
                    'marque_id' => $marque->id,
                ]);
            }
        });
    }
}
