<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VilleMaroc extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            "Casablanca",
            "Rabat",
            "Fès",
            "Marrakech",
            "Agadir",
            "Tanger",
            "Salé",
            "Meknès",
            "Oujda",
            "Kenitra",
            "Tétouan",
            "Safi",
            "Mohammedia",
            "El Jadida",
            "Beni Mellal",
            "Nador",
            "Taza",
            "Khémisset",
            "Essaouira",
            "Settat",
            "Berrechid",
            "Tanger",
            "Tétouan",
            "Laayoune",
            "Khouribga",
            "El Kelaa des Sraghna",
            "Sidi Kacem",
            "Ouarzazate",
            "Béni Mellal",
            "Tiznit",
            "Taourirt",
            "Dakhla",
            "Tinghir",
            "Témara",
            "Skhirat",
            "Youssoufia",
            "Taroudant",
            "Oulad Teima",
            "Sidi Slimane",
            "Larache",
            "Guelmim",
            "Ksar El Kebir",
            "Errachidia",
            "Berkane",
            "Sefrou",
            "Chefchaouen",
            "El Hajeb",
            "Fquih Ben Salah",
            "Sidi Bennour",
            "Midelt",
            "Azrou",
            "Ifrane",
            "Tiznit",
            "Taourirt",
            "Dakhla",
            "Tinghir",
            "Témara",
            "Skhirat",
            "Youssoufia",
            "Taroudant",
            "Oulad Teima",
            "Sidi Slimane",
            "Larache",
            "Guelmim",
            "Ksar El Kebir",
            "Errachidia",
            "Berkane",
            "Sefrou",
            "Chefchaouen",
            "El Hajeb",
            "Fquih Ben Salah",
            "Sidi Bennour",
            "Midelt",
            "Azrou",
            "Ifrane"
        ];
        foreach ($cities as $city) {
            Ville::create([
                'nom' => $city,
            ]);
        }
    }
}
