<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\json;

class AnnonceController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Annonce;
        $this->model_name = 'Annonce';
    }
    public function selectRelations(): array
    {
        return [
            'marque'  => [
                'table'           => 'marques',
                'field'           => 'marque_id',
                'primary_key'     =>'id',
                'relation_column' =>
                    [   'id',
                        'nom',
                        'image'
                    ],
            ],
            'modele'  => [
                'table'           => 'modeles',
                'field'           => 'modele_id',
                'primary_key'     =>'id',
                'relation_column' =>
                    [   'id',
                        'nom',
                    ],
            ],
            'couleur' => [
                'table'           => 'couleurs_voitures',
                'field'           => 'couleur_id',
                'primary_key'     =>'id',
                'relation_column' =>
                    [   'id',
                        'nom',
                    ],
            ],
            'ville'   => [
                'table'           => 'villes',
                'field'           => 'ville_id',
                'primary_key'     =>'id',
                'relation_column' =>
                    [   'id',
                        'nom',
                    ],
            ],
            'owner'   => [
                'table'           => 'users',
                'field'           => 'owner_id',
                'primary_key'     =>'id',
                'relation_column' =>
                    [   'id',
                        'nom',
                        'prenom',
                        'email',
                        'telephone'
                    ],
            ],

        ] ;
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
                'kilometrage' => ['required', 'integer', 'min:1'],
                'image.*' => 'image|mimes:jpeg,png,pdf|max:2048',
                'image' => 'required',
                'annee_fabrication' => ['required', 'date_format:Y'],
                'etat' => ['required', Rule::in('neuf', 'occasion')],
                'prix_vente' => [
                    Rule::requiredIf(
                        $this->request->type_annonce == 'vente'
                    ),
                    Rule::excludeIf($this->request->type_annonce == 'location'),
                    'gt:2'
                ],
                'prix_location' => [Rule::requiredIf($this->request->type_annonce == 'location'), Rule::excludeIf($this->request->type_annonce == 'vente'), 'min:1'],
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
        $data = $this->request->all();
        $data['owner_id'] = auth()->user()->id;
        if ($this->request->options) {
            $options = [];
            foreach ($this->request->options as $option) {
                $options[] = $option;
            }
            $data['options'] = json_encode($options);
        }
        if ($data['etat'] != 'occasion' && Auth::user()->role == 'client') {
            return ['error' => ['etat' => ['Seules les responsable peuvent changer l\'etat d\'une annonce']]];
        } else if ($data['etat'] == 'occasion') {
            if ($this->request->type_annonce == 'vente') {
                $data['prix_location'] = null;
                $data["disponibilite_location"] = null;
            } else if ($this->request->type_annonce == 'location') {
                $data['prix_vente'] = null;
                $data["disponibilite_vente"] = null;
            }
        } else if ($data['etat'] == 'neuf') {

        }
        unset($data['image']);
        return $data;
    }
    public function afterSaveForStore($new_model)
    {
        $image = $this->request->file('image') ?? null;
        // adding image to the form
        if ($image) {
            $paths = [];
            foreach ($this->request->file('image') as $image) {
                $path = $image->store('images/annonces', 'public');
                $paths[] = $path;
            }
            $new_model->update(['image' => json_encode($paths)]);
        }
    }
    // show
    public function beforeReturnForShow($data)
    {
        if (strpos($this->request->url(), 'admin') === false && $data->statut_annonce != 'approved') {
            return null;
        } else
            return $data;
    }
    public function indexOccasion()
    {
        $fromBack = $this->request->source ?? false;
        if (!$fromBack) {
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
            ]
        ];

        $this->filteringDisplay("location");

        return $this->indexPaginate();
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
        $this->filteringDisplay();

        return $this->indexPaginate();
    }
    // getters
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
