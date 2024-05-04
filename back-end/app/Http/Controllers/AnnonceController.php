<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Location;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\LocationController;
use Illuminate\Validation\ValidationException;

class AnnonceController extends ParentController
{
    public function __construct()
    {

        $this->model = Annonce::class;
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy', 'updateStatus', 'updateDisponibilite']);
        $this->model_name = 'Annonce';
        parent::__construct();
    }
    public function selectRelations(): array
    {
        return [
            'marque'  => [
                'table'           => 'marques',
                'field'           => 'marque_id',
                'primary_key'     => 'id',
                'relation_column' =>
                [
                    'id',
                    'nom',
                    'image'
                ],
            ],
            'modele'  => [
                'table'           => 'modeles',
                'field'           => 'modele_id',
                'primary_key'     => 'id',
                'relation_column' =>
                [
                    'id',
                    'nom',
                ],
            ],
            'couleur' => [
                'table'           => 'couleurs_voitures',
                'field'           => 'couleur_id',
                'primary_key'     => 'id',
                'relation_column' =>
                [
                    'id',
                    'nom',
                ],
            ],
            'ville'   => [
                'table'           => 'villes',
                'field'           => 'ville_id',
                'primary_key'     => 'id',
                'relation_column' =>
                [
                    'id',
                    'nom',
                ],
            ],
            'owner'   => [
                'table'           => 'users',
                'field'           => 'owner_id',
                'primary_key'     => 'id',
                'relation_column' =>
                [
                    'id',
                    'nom',
                    'prenom',
                    'email',
                    'telephone'
                ],
            ],

        ];
    }
    public function beforeValidateForStore()
    {
        $this->rules =
            [
                'titre' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'ville_id' => ['required', 'exists:villes,id'],
                'carburant' => ['required', Rule::in('diesel', 'hybride', 'essence', 'electrique')],
                'type_annonce' => ['required', Rule::in(['vente', 'location'])],
                'marque_id' => ['required', 'exists:marques,id'],
                'modele_id' => ['required', 'exists:modeles,id'],
                'couleur_id' => ['required', 'exists:couleurs_voitures,id'],
                'kilometrage' => ['required', 'integer', 'gt:-1'],
                'image.*' => 'image|mimes:jpeg,png,pdf|max:2048',
                'image' => 'required',
                'annee_fabrication' => ['required', 'date_format:Y'],
                'etat' => ['required', Rule::in('neuf', 'occasion')],
                'prix_vente' => [
                    Rule::requiredIf(
                        $this->request->type_annonce == 'vente'
                    ),
                    Rule::excludeIf($this->request->type_annonce == 'location'),
                    'gt:10000'
                ],
                'prix_location' => [Rule::requiredIf($this->request->type_annonce == 'location'), Rule::excludeIf($this->request->type_annonce == 'vente'), 'gt:50'],
                'disponibilite_vente' => [
                    Rule::requiredIf($this->request->type_annonce == 'vente'),
                    Rule::excludeIf($this->request->type_annonce ==
                        'location'),
                    Rule::in('vendu', 'disponible', 'indisponible')
                ],
                'disponibilite_location' => [Rule::requiredIf($this->request->type_annonce == 'location'), Rule::excludeIf($this->request->type_annonce == 'vente'), Rule::in('louer', 'disponible', 'indisponible')],
            ];
    }

    public function beforeSaveForStore()
    {
        $data = $this->request->except(['image']);
        $data['owner_id'] = auth()->user()->id;
        // setting options
        if ($this->request->options) {
            $options = [];
            foreach ($this->request->options as $option) {
                $options[] = $option;
            }
            $data['options'] = json_encode($options);
        }
        // setting default values
        if ($this->request->type_annonce == 'vente') {
            $data['prix_location'] = null;
            $data["disponibilite_location"] = null;
        } else if ($this->request->type_annonce == 'location') {
            $data['prix_vente'] = null;
            $data["disponibilite_vente"] = null;
        }
        // verifying if the user is a client and the request
        if ($data['etat'] != 'occasion' && (!Auth::check() || Auth::user()->role == 'client')) {
            return ['error' => ['etat' => ['Seules les responsable peuvent changer l\'etat d\'une annonce']]];
        } else if ($data['etat'] == 'occasion') {
            if ($data["kilometrage"] == 0) {
                return ['error' => ['kilometrage' => ['Le kilometrage doit etre superieur a 0 pour une annonce occasion']]];
            }
        } else if ($data['etat'] == 'neuf') {
            if ($data["kilometrage"] != 0) {
                return ['error' => ['kilometrage' => ['Le kilometrage doit etre egale a 0 pour une annonce neuf']]];
            }
        }
        return $data;
    }
    public function afterSaveForStore($new_model)
    {
        $images = $this->request->file('image') ?? null;
        // adding image to the form
        if ($images) {
            $paths = [];
            foreach ($images as $image) {
                $path = $image->store('images/annonces', 'public');
                $paths[] = $path;
            }
            $new_model->update(['image' => json_encode($paths)]);
        }
    }
    // updating
    public function beforeValidateForUpdate()
    {
        $this->rules =
            [
                'titre' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'ville_id' => ['required', 'exists:villes,id'],
                'carburant' => ['required', Rule::in('diesel', 'hybride', 'essence', 'electrique')],
                'type_annonce' => ['required', Rule::in(['vente', 'location'])],
                'marque_id' => ['required', 'exists:marques,id'],
                'modele_id' => ['required', 'exists:modeles,id'],
                'couleur_id' => ['required', 'exists:couleurs_voitures,id'],
                'kilometrage' => ['required', 'integer', 'gt:-1'],
                'old_image' => ['nullable'],
                'old_image.*' => ['nullable', 'string'],
                'image' => 'required_if:old_image,null',
                'image.*' =>  ['required_if:old_image,null', 'image', 'mimes:jpeg,svg,png', 'max:2048'],
                'annee_fabrication' => ['required', 'date_format:Y'],
                'etat' => ['required', Rule::in('neuf', 'occasion')],
                'prix_vente' => [
                    Rule::requiredIf(
                        $this->request->type_annonce == 'vente'
                    ),
                    Rule::excludeIf($this->request->type_annonce == 'location'),
                    'gt:10000'
                ],
                'prix_location' => [Rule::requiredIf($this->request->type_annonce == 'location'), Rule::excludeIf($this->request->type_annonce == 'vente'), 'gt:50'],
                'disponibilite_vente' => [
                    Rule::requiredIf($this->request->type_annonce == 'vente'),
                    Rule::excludeIf($this->request->type_annonce ==
                        'location'),
                    Rule::in('vendu', 'disponible', 'indisponible')
                ],
                'disponibilite_location' => [Rule::requiredIf($this->request->type_annonce == 'location'), Rule::excludeIf($this->request->type_annonce == 'vente'), Rule::in('louer', 'disponible', 'indisponible')],
            ];
    }

    public function beforeSaveForUpdate($current_model)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return ['response' => ['message' => 'Veuillez vous connecter', 'iconColor' => 'red']];
        }

        // Check if the user is authorized to update the model
        if ($current_model["owner_id"] != Auth::user()->id && Auth::user()->role == "client") {
            return ['response' => ['message' => 'Seules les responsables peuvent changer les annonces des clients', 'iconColor' => 'red']];
        }

        // Check if the model is not already sold or rented
        if ($current_model->disponibilite_vente == 'vendu' || $current_model->disponibilite_location == 'louer') {
            return response()->json(['message' => "Les voitures vendues/louées ne peuvent pas être modifiées", 'iconColor' => 'red']);
        }

        // Verify if the model's announcement status is approved
        if ($current_model->statut_annonce != 'approved') {
            return response()->json(['message' => "L'annonce doit être approuvée pour pouvoir modifier sa disponibilité", 'iconColor' => 'red']);
        }

        $data = $this->request->except(['image']);

        // Convert options array to JSON if provided
        if ($this->request->has('options')) {
            $data['options'] = json_encode($this->request->options);
        }

        // Setting default values based on type_annonce
        if ($this->request->type_annonce == 'vente') {
            $data['prix_location'] = null;
            $data["disponibilite_location"] = null;
        } elseif ($this->request->type_annonce == 'location') {
            $data['prix_vente'] = null;
            $data["disponibilite_vente"] = null;
        }

        // Verify if the user is authorized to change the model's state
        if ($data['etat'] != 'occasion' && Auth::user()->role == 'client') {
            return ['error' => ['etat' => ['Seules les responsables peuvent changer l\'état d\'une annonce']]];
        }

        // Additional validations based on etat
        if ($data['etat'] == 'occasion' && $data["kilometrage"] == 0) {
            return ['error' => ['kilometrage' => ['Le kilométrage doit être supérieur à 0 pour une annonce occasion']]];
        } elseif ($data['etat'] == 'neuf' && $data["kilometrage"] != 0) {
            return ['error' => ['kilometrage' => ['Le kilométrage doit être égal à 0 pour une annonce neuve']]];
        }

        return $data;
    }
    public function afterSaveForUpdate($current_model)
    {
        $images = $this->request->file('image') ?? null;
        $current_model_images = json_decode($current_model->image);
        $old_images = $this->request->get('old_image') ?? null;
        $diff = array_diff($current_model_images, $old_images);
        $paths = [];
        foreach ($diff as $image) {
            if (strpos($image, "assets") === false) {
                Storage::delete('public/' . $image);
            }
        }
        // adding image to the form
        if ($images) {
            foreach ($images as $image) {
                $path = $image->store('images/annonces', 'public');
                $paths[] = $path;
            }
        }
        $current_model->update(['image' => json_encode(array_merge($old_images, $paths))]);
        // adding image to the form

    }
    // update Status only
    public function updateStatus($id)
    {
        $data = $this->model->find($id);
        if (Auth::user()->role == "client") {
            return response()->json(['message' => "Seules les responsables peuvent changer le statut d'une annonce", 'iconColor' => 'red']);
        }
        $formElements = $this->request->validate([
            'statut_annonce' => ['required', Rule::in(['approved', 'onhold', 'disabled'])],
        ]);
        if ($data->update($formElements)) {
            return response()->json(['message' => "Statut modifié avec succès", 'iconColor' => 'blue']);
        } else {
            return abort(400, 'la modification a echoué');
        }
    }
    // update disponibilite only
    public function updateDisponibilite($id)
    {
        $data = $this->model->find($id);

        // Authorization Check
        if ($data['owner_id'] != Auth::user()->id && Auth::user()->role == "client") {
            return response()->json(['message' => "Seules les proprietaires / responsables peuvent changer le statut d'une annonce", 'iconColor' => 'red']);
        }
        // verify approval

        if ($data->statut_annonce != 'approved') {
            return response()->json(['message' => "L'annonce doit être approuvée pour pouvoir modifer sa disponibilité", 'iconColor' => 'red']);
        }

        // Check if the item is not already vendu or loaned
        if ($data->disponibilite_vente == 'vendu' || $data->disponibilite_location == 'louer') {
            return response()->json(['message' => "Les voitures vendue/louer ne peuvent pas étre remodifiée", 'iconColor' => 'red']);
        }

        // Validation
        $validatedData = [];
        if ($data->type_annonce == 'vente') {
            $validatedData = $this->request->validate([
                'disponibilite_vente' => ['required', Rule::in(['vendu', 'disponible', 'indisponible'])],
            ]);

            // If the announcement type is 'vente' and  'vendu',  Vente update
            if ($validatedData['disponibilite_vente'] == 'vendu') {
                $VenteController = new VenteController;
                $VenteController->storeVente($data);
            }
        } elseif ($data->type_annonce == 'location') {
            $validatedData = $this->request->validate([
                'disponibilite_location' => ['required', Rule::in(['louer', 'disponible', 'indisponible'])],
            ]);

            // If the announcement type is 'location' and  'louer',  location update
            if ($validatedData['disponibilite_location'] == 'louer') {
                $locationController = new LocationController;
                $response = $locationController->storeLocation($this->request, $data);
                if ($response !== true) {
                    return $response;
                }
            }
        }

        if (!$data->update($validatedData)) {
            return abort(400, 'la modification a echoué');
        }
        return response()->json(['message' => "Disponibilité modifié avec succès", 'iconColor' => 'blue']);
    }

    // Deleting
    public function beforeDestroy($current_model)
    {
        if (Auth::user()->role == 'client' && $current_model->owner_id != Auth::user()->id) {
            return ['response' => ['message' => 'Vous n\'avez pas le droit de supprimer cette annonce', 'iconColor' => 'red']];
        } else if ($current_model->disponibilite_vente == 'vendu' || $current_model->disponibilite_location == 'louer') {
            return ['response' => ['message' => "Les voitures vendue/louer ne peuvent pas étre supprimée", 'iconColor' => 'red']];
        }

        return $current_model;
    }
    // show
    public function beforeReturnForShow($data)
    {
        if (!Auth::check() && $data->statut_annonce != 'approved') {
            return null;
        } else if (Auth::check() && Auth::user()->id == $data->owner_id) {
            return $data;
        } else if ($data->statut_annonce != 'approved' && !in_array(Auth::user()->role, ['admin', 'root'])) {
            return null;
        } else
            return $data;
    }
    public function indexOccasion()
    {
        $fromBack = $this->request->source ?? false;
        $defaultCondition = [
            [
                'column' => 'etat',
                'operator' => 'like',
                'value' => 'occasion'
            ],
        ];
        if (!$fromBack) {
            $this->conditions = [
                ...$defaultCondition,
                [
                    'column' => 'statut_annonce',
                    'operator' => 'like',
                    'value' => 'approved'
                ],
                [
                    'column' => 'disponibilite_vente',
                    'operator' => 'like',
                    'value' => 'disponible'
                ],
                [
                    'column' => 'type_annonce',
                    'operator' => 'like',
                    'value' => 'vente'
                ]
            ];
        } else if ($fromBack && !in_array(Auth::user()->role, ['admin', 'root'])) {
            abort(400, 'Unauthorized action');
        }
        $this->filteringDisplay();

        return $this->indexPaginate();
    }
    public function indexLocation()
    {
        $this->conditions = [
            [
                'column' => 'type_annonce',
                'operator' => 'like',
                'value' => 'location'
            ],
            [
                'column' => 'statut_annonce',
                'operator' => 'like',
                'value' => 'approved'
            ], [
                'column' => 'disponibilite_location',
                'operator' => 'like',
                'value' => 'disponible'
            ],
        ];

        $this->filteringDisplay("location");

        return $this->indexPaginate();
    }
    public function indexNeuf()
    {
        $fromBack = $this->request->source ?? false;
        $defaultCondition = [
            [
                'column' => 'etat',
                'operator' => 'like',
                'value' => 'neuf'
            ],
        ];
        if (!$fromBack) {
            $this->conditions = [
                ...$defaultCondition,
                [
                    'column' => 'statut_annonce',
                    'operator' => 'like',
                    'value' => 'approved'
                ],
                [
                    'column' => 'disponibilite_vente',
                    'operator' => 'like',
                    'value' => 'disponible'
                ],
                [
                    'column' => 'type_annonce',
                    'operator' => 'like',
                    'value' => 'vente'
                ]
            ];
        } else if ($fromBack && !in_array(Auth::user()->role, ['admin', 'root'])) {
            abort(400, 'Unauthorized action');
        }

        $this->filteringDisplay();

        return $this->indexPaginate();
    }
    // getters
    public function getUserAnnonces()
    {
        $this->conditions = [
            [
                'column' => 'owner_id',
                'operator' => 'like',
                'value' => Auth::user()->id
            ],
        ];

        return $this->indexPaginate();
    }
    public function getAnneeFabrication()
    {
        return $this->model::select('annee_fabrication as annees')->distinct()->orderBy('annee_fabrication', 'desc')->get();
    }
    public function getMaxPriceLocation()
    {
        return ['max_price' => $this->model::max('prix_location')];
    }
    public function getMaxPriceVenteOccasion()
    {
        return ['max_price' => $this->model::where('etat', 'occasion')->max('prix_vente')];
    }
    public function getMaxPriceVenteNeuf()
    {
        return ['max_price' => $this->model::where('etat', 'neuf')->max('prix_vente')];
    }
    public function getTopVilles()
    {
        return $this->model->leftjoin('villes', 'ville_id', '=', 'villes.id')->select('ville_id', 'villes.nom', DB::raw('COUNT(*) as count'))->groupBy('ville_id', 'villes.nom')->orderBy('count', 'desc')->take(6)->get();
    }
    public function getTopMarques()
    {
        return $this->model->leftjoin('marques', 'marque_id', '=', 'marques.id')->select('marque_id', 'marques.nom', DB::raw('COUNT(*) as count'))->groupBy('marque_id', 'marques.nom')->orderBy('count', 'desc')->take(6)->get();
    }

    // local helpers
    public function filteringDisplay($type = "vente")
    {
        $fromBack = $this->request->source ?? false;
        if (!$fromBack) {
            $this->conditions[] = [
                'column' => 'statut_annonce',
                'operator' => 'like',
                'value' => 'approved'
            ];
            // array of filters
            $filters = [
                'ville_id' => !empty($this->request->ville_id) ? $this->request->ville_id : null,
                'carburant' => !empty($this->request->carburant) ? $this->request->carburant : null,
                'marque_id' => !empty($this->request->marque_id) ? $this->request->marque_id : null,
                'modele_id' => !empty($this->request->modele_id) ? $this->request->modele_id : null,
                'annee_fabrication' => !empty($this->request->annee_fabrication) ? $this->request->annee_fabrication : null,
            ];
            // needs special treatment
            $specialFilters = [
                'maxKilometrage' => !empty($this->request->maxKilometrage) ? $this->request->maxKilometrage : null,
                'min_price' => !empty($this->request->min_price) ? $this->request->min_price : null,
                'max_price' => !empty($this->request->max_price) ? $this->request->max_price : null,
            ];

            foreach ($filters as $key => $value) {
                if ($value) {
                    $this->conditions[] = [
                        'column' => $key,
                        'operator' => 'like',
                        'value' => $value
                    ];
                }
            }
            if ($specialFilters["maxKilometrage"]) {
                $this->conditions[] = [
                    'column' => 'kilometrage',
                    'operator' => '<=',
                    'value' => $specialFilters['maxKilometrage']
                ];
            }
            if ($specialFilters["min_price"]) {
                if ($type == "vente") {
                    $this->conditions[] = [
                        'column' => 'prix_vente',
                        'operator' => '>=',
                        'value' => $specialFilters['min_price']
                    ];
                } elseif ($type == "location") {
                    $this->conditions[] = [
                        'column' => 'prix_location',
                        'operator' => '>=',
                        'value' => $specialFilters['min_price']
                    ];
                }
            }
            if ($specialFilters["max_price"]) {
                if ($type == "vente") {
                    $this->conditions[] = [
                        'column' => 'prix_vente',
                        'operator' => '<=',
                        'value' => $specialFilters['max_price']
                    ];
                } elseif ($type == "location") {
                    $this->conditions[] = [
                        'column' => 'prix_location',
                        'operator' => '<=',
                        'value' => $specialFilters['max_price']
                    ];
                }
            }
        }
    }
}
