<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $annonces = [
            'owner_id' => fake()->numberBetween(1, 10),
            'marque_id' => fake()->numberBetween(1, 15),
            'couleur_id' => fake()->numberBetween(1, 20),
            'titre' => fake()->sentence(3),
            'description' => fake()->sentence(10),
            'ville_id' => fake()->numberBetween(1, 25),
            'type_annonce' => fake()->randomElement(['vente', 'location']),
            'etat' => fake()->randomElement(['neuf', 'occasion']),
            'carburant' => fake()->randomElement(['diesel', 'hybride', 'essence', 'electrique']),
            'kilometrage' => fake()->numberBetween(1, 10000),
            'annee_fabrication' => fake()->year(),
            'options' => json_encode(['option1', 'option2','option3','option4','option5','option6','option7','option8','option9','option10']),
            'image' => json_encode(['assets/annonces/1.png', 'assets/annonces/2.jpeg']),
            'statut_annonce' => fake()->randomElement(['approved', 'onhold']),
        ];
        $annonces['modele_id'] = fake()->numberBetween($annonces['marque_id'] * 3 - 2, $annonces['marque_id'] * 3);
        if ($annonces['type_annonce'] == 'vente') {
            $annonces['prix_vente'] = fake()->numberBetween(1000, 100000);
            $annonces['prix_location'] = null;
            $annonces['disponibilite_vente'] = 'disponible';
            $annonces['disponibilite_location'] = null;
        } elseif ($annonces['type_annonce'] == 'location') {
            $annonces['prix_vente'] = null;
            $annonces['prix_location'] = fake()->numberBetween(1, 1000);
            $annonces['disponibilite_vente'] = null;
            $annonces['disponibilite_location'] = 'disponible';
        }
        return $annonces;
    }
}
