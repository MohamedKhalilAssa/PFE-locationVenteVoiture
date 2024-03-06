<?php

namespace Database\Seeders;

use App\Models\couleursVoiture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouleursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['nom' => 'Blanc', 'hex' => '#FFFFFF'],
            ['nom' => 'Noir', 'hex' => '#000000'],
            ['nom' => 'Gris', 'hex' => '#808080'],
            ['nom' => 'Rouge', 'hex' => '#FF0000'],
            ['nom' => 'Vert', 'hex' => '#00FF00'],
            ['nom' => 'Bleu', 'hex' => '#0000FF'],
            ['nom' => 'Jaune', 'hex' => '#FFFF00'],
            ['nom' => 'Orange', 'hex' => '#FFA500'],
            ['nom' => 'Violet', 'hex' => '#800080'],
            ['nom' => 'Rose', 'hex' => '#FFC0CB'],
            ['nom' => 'Marron', 'hex' => '#964B00'],
            ['nom' => 'Turquoise', 'hex' => '#40E0D0'],
            ['nom' => 'Argent', 'hex' => '#C0C0C0'],
            ['nom' => 'Or', 'hex' => '#FFD700'],
            ['nom' => 'Cyan', 'hex' => '#00FFFF'],
            ['nom' => 'Magenta', 'hex' => '#FF00FF'],
            ['nom' => 'Bordeaux', 'hex' => '#800000'],
            ['nom' => 'Olive', 'hex' => '#808000'],
            ['nom' => 'Beige', 'hex' => '#F5F5DC'],
            ['nom' => 'Indigo', 'hex' => '#4B0082'],
        ];


        foreach ($colors as $color) {
            couleursVoiture::create([
                'nom' => $color['nom'],
                'Hexadecimal' => $color['hex']
            ]);
        }
    }
}
