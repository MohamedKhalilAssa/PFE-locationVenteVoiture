<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AnnonceController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = Annonce::class;
        $this->middleware('auth:sanctum')->except(['indexNeuf', 'indexOccasion', 'show', 'indexLocation']);
        $this->middleware('admin')->except(['indexNeuf', 'indexOccasion', 'show', 'indexLocation']);
    }
    public function selectRelations(): array
    {
        return [
            'marque' => [
                'id',
                'nom',
                'image'
            ],
            'modele' => [
                'id',
                'nom'
            ],
            'couleur' => [
                'id',
                'nom'
            ],
            'ville' => [
                'id',
                'nom'
            ],
            'owner' => [
                'id',
                'nom',
                'prenom'
            ]
        ];
    }
    public function occasionStore(Request $request)
    {
        $formElements = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'ville' => ['required', 'exists:villes,id'],
            'carburant' => ['required', Rule::in('diesel', 'hybride', 'essence', 'electrique')],
            'type_annonce' => ['required', Rule::in(['vente', 'location'])],
            'marque_id' => ['required', 'exists:marques,id'],
            'modele_id' => ['required', 'exists:modeles,id'],
            'couleur_id' => ['required', 'exists:couleurs_voitures,id'],
            'kilometrage' => ['required', 'integer', 'min:1'],
            'image.*' => 'image|mimes:jpeg,png,pdf|max:2048',
            'image' => 'required',
            'annee_fabrication' => ['required', 'date_format:Y'],
            'prix_vente' => [
                Rule::requiredIf(
                    $request->type_annonce == 'vente'
                ),
                Rule::excludeIf($request->type_annonce == 'location'),
                'gt:2'
            ],
            'prix_location' => [Rule::requiredIf($request->type_annonce == 'location'), Rule::excludeIf($request->type_annonce == 'vente'), 'min:1'],
            'disponibilite_vente' => [
                Rule::requiredIf($request->type_annonce == 'vente'),
                Rule::excludeIf($request->type_annonce ==
                    'location'),
                Rule::in('vendu', 'disponible', 'indisponible')
            ],
            'disponibilite_location' => [Rule::requiredIf($request->type_annonce == 'location'), Rule::excludeIf($request->type_annonce == 'vente'), Rule::in('louer', 'disponible', 'indisponible')],
        ]);
        // default values
        $formElements['owner_id'] = auth()->user()->id;
        $formElements['etat'] = 'occasion';

        // adding images to the form
        if ($request->file('image')) {
            $paths = [];
            foreach ($request->file('image') as $image) {
                $path =  $image->store('images/annonces', 'public');
                $paths[] = $path;
            }
            $formElements['image'] = json_encode($paths);
        }
        // adding options to the form
        if ($request->options) {
            $options = [];
            foreach ($request->options as $option) {
                $options[] = $option;
            }
            $formElements['options'] = json_encode($options);
        }
        Annonce::create($formElements);
        return response()->json(['message' => "Annonce Crée avec succès"]);
    }
    public function indexOccasion()
    {
        $this->conditions = [
            [
                'column' => 'etat',
                'operator' => 'like',
                'value' => 'occasion'
            ],
            [
                'column' => 'type_annonce',
                'operator' => 'like',
                'value' => 'vente'
            ]
        ];
        return  $this->indexPaginate();
    }
    public function indexLocation()
    {
        $this->conditions = [
            [
                'column' => 'type_annonce',
                'operator' => 'like',
                'value' => 'location'
            ]
        ];
        return  $this->indexPaginate();
    }
    public function indexNeuf()
    {
        $this->conditions = [
            [
                'column' => 'etat',
                'operator' => 'like',
                'value' => 'neuf'
            ],
            [
                'column' => 'type_annonce',
                'operator' => 'like',
                'value' => 'vente'
            ]
        ];
        return  $this->indexPaginate();
    }
}
