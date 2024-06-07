<?php

namespace Database\Factories;

use App\Models\Marque;
use App\Models\Modele;
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
    private $options = ['Sieges_chauffants', 'toutes_options', 'GPS', 'Camera_recul', 'Regulateur_vitesse', 'Ordinateur_de_bord', 'ABS', 'Vitres_electriques', 'Airbags', 'Anti_brouillard'];
    public function definition(): array
    {
        $elements = fake()->randomElements($this->options, 3);
        $annonces = [
            'owner_id' => fake()->numberBetween(1, 12),
            'marque_id' => fake()->numberBetween(1, 5),
            'couleur_id' => fake()->numberBetween(1, 20),
            'description' => fake()->sentence(10),
            'ville_id' => fake()->numberBetween(1, 25),
            'type_annonce' => fake()->randomElement(['vente', 'location']),
            'etat' => fake()->randomElement(['neuf', 'occasion']),
            'carburant' => fake()->randomElement(['diesel', 'hybride', 'essence', 'electrique']),
            'kilometrage' => fake()->numberBetween(1, 10000),
            'annee_fabrication' => fake()->numberBetween(2000, 2024),
            'options' => in_array('toutes_options', $elements) ? json_encode('toutes_options') : json_encode($elements),
            'statut_annonce' => fake()->randomElement(['approved', 'onhold']),
        ];
        $annonces['modele_id'] =  fake()->numberBetween($annonces['marque_id'] * 4 - 2, $annonces['marque_id'] * 4);
        $modele = Modele::find($annonces['modele_id']);
        $annonces['titre'] = "{$modele->marque->nom} {$modele->nom} modèle {$annonces['annee_fabrication']} {$annonces['carburant']}";
        $modele = $annonces['modele_id'] % 4 == 0 ? 4 : $annonces['modele_id'] % 4;
        $annonces['image'] = json_encode(['assets/annonces/' . $annonces['marque_id'] . '_' . $modele . '_' . $annonces['etat'] . '1.png', 'assets/annonces/' . $annonces['marque_id'] . '_' . $modele . '_' . $annonces['etat'] . '2.png']);



        if ($annonces['type_annonce'] == 'vente') {
            $annonces['prix_vente'] = fake()->numberBetween(10000, 100000);
            $annonces['prix_location'] = null;
            $annonces['disponibilite_vente'] = 'disponible';
            $annonces['disponibilite_location'] = null;
        } elseif ($annonces['type_annonce'] == 'location') {
            $annonces['etat'] = 'occasion';
            $annonces['prix_vente'] = null;
            $annonces['prix_location'] = fake()->numberBetween(1, 1000);
            $annonces['disponibilite_vente'] = null;
            $annonces['disponibilite_location'] = 'disponible';
        }
        $annonces['kilometrage'] = $annonces['etat'] == 'neuf' ? 0 : $annonces['kilometrage'];
        return $annonces;
    }
}
