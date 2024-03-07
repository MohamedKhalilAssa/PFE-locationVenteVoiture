<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AnnonceController extends Controller
{
    public function occasionStore(Request $request)
    {
        $formElements = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'ville' => ['required', 'string'],
            'carburant' => ['required', Rule::enum(Annonce::class)],
            'type_annonce' => ['required', Rule::enum(Annonce::class)],
            'modele_id' => ['required', 'exists:modeles,id'],
            'marque_id' => ['required', 'exists:marques,id'],
            'couleur_id' => ['required', 'exists:couleurs,id'],
            'prix_vente' => ['required', 'Decimal', 'min:1'],
            'kilometrage' => ['required', 'integer', 'min:1'],
            'annee_fabrication' => ['required', 'date_format:Y'],

        ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        $formElements['etat'] = 'occasion';

        return response()->json($request->all());
    }
}
