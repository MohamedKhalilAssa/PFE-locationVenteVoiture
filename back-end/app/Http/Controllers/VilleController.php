<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends ParentController
{
    public function __construct()
    {
        $this->model = Ville::class;
        $this->model_name = 'Ville';
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
        parent::__construct();
    }

    public function beforeGetting()
    {
        $this->model->orderBy('nom');
    }
    // Overriding
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => ['required', 'unique:villes,nom', 'regex:/^\D*$/', 'string', 'max:255'],
        ];
    }
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
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
}
