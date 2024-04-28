<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Http\Request;

class ModeleController extends ParentController
{
    public function __construct()
    {
        $this->model = Modele::class;
        $this->model_name = 'Modele';
        $this->middleware('auth:sanctum')->except(['index', 'show', 'showbyMarque']);
        $this->middleware('admin')->except(['index', 'show', 'showbyMarque']);
        parent::__construct();
    }
    // for indexBack
    public function selectRelations(): array
    {
        return [
            'marque' => [
                'table' => 'marques',
                'field' => 'marque_id',
                'primary_key' => 'id',
                'relation_column' =>
                [
                    'id',
                    'nom',
                ],
            ],
        ];
    }
    // Overriding the before methods to specify rules
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => ['required', 'unique:modeles,nom', 'string', 'regex:/^[a-zA-Z]{1,}\w*/', 'max:255'],
            'marque_id' => ['required', 'integer', "exists:marques,id"],

        ];
    }
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^[a-zA-Z]{1,}\w*/', 'max:255'],
            'marque_id' => ['required', 'integer', "exists:marques,id"],
        ];
    }
    public function beforeSaveForUpdate($current_model)
    {
        $data = $this->request->all();
        $found = $this->model::where('nom', $data['nom'])->first() ?? false;
        if ($found != false && $data['nom'] != $current_model->nom) {
            return  ['error' => ['nom' => [$this->model_name . ' existe deja']]];
        } else {
            return $data;
        }
    }
    public function showbyMarque($id)
    {
        return response(Marque::find($id)->modeles()->orderBy('nom')->get(["id", "nom"]))->header('Content-Type', 'application/json');
    }
}
