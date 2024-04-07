<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends ParentController
{
    public function __construct()
    {
        $this->model = Marque::class;
        $this->model_name = 'Marque';
        $this->middleware('auth:sanctum')->except(['index', 'indexBack', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    // specify columns to be returned from ::all (optional)
    public function indexReturnedColumns()
    {
        return ['id', 'nom'];
    }
    // Overriding the before methods to specify rules
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => ['required', 'unique:marques,nom', 'string', 'regex:/^\D*$/', 'max:255'],
        ];
    }
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
        ];
    }
    // public function store(Request $request)
    // {
    //     $formElements = $request->validate([
    //         'nom' => ['required', 'unique:marques,nom', 'string', 'regex:/^\D*$/', 'max:255'],
    //     ]);
    //     Marque::create([
    //         'nom' => $formElements['nom'],
    //     ]);
    //     return response()->json(['message' => 'Marque crée avec succès']);
    // }
    // public function update(Request $request, $id)
    // {
    //     $formElements = $request->validate([
    //         'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
    //     ]);
    //     $marque = Marque::find($id);
    //     if (!$marque) {
    //         return abort(404, 'Modele not found');
    //     }
    //     $marque->nom = $formElements['nom'];
    //     if ($marque->save()) {
    //         return response()->json(['message' => 'Marque modifié avec succès', 'iconColor' => 'blue']);
    //     } else {
    //         return abort(400, 'la modification a echoué');
    //     }
    // }

}
