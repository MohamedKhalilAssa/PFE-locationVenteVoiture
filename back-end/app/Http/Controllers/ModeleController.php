<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Http\Request;

class ModeleController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = Modele::class;
        $this->model_name = 'Modele';
        $this->middleware('auth:sanctum')->except(['index', 'show','showbyMarque']);
        $this->middleware('admin')->except(['index', 'show', 'showbyMarque']);
    }
    // for indexBack
    public function selectRelations(): array
    {
        return [
            'marque' => [
                'id',
                'nom'
            ]
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
    public function showbyMarque($id)
    {
        return response(Marque::find($id)->modeles()->get(["id", "nom"]))->header('Content-Type', 'application/json');
    }

}
