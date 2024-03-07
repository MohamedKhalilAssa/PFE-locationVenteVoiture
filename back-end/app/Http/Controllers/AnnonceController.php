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
            'carburant' => ['required', Rule::in('diesel', 'hybride', 'essence', 'electrique')],
            'type_annonce' => ['required', Rule::in(['vente', 'location'])],
            'marque_id' => ['required', 'exists:marques,id'],
            'modele_id' => ['required', 'exists:modeles,id'],
            'couleur_id' => ['required', 'exists:couleurs_voitures,id'],
            'kilometrage' => ['required', 'integer', 'min:1'],
            'annee_fabrication' => ['required', 'date_format:Y'],
            'prix_vente' => [Rule::requiredIf(
                $request->type_annonce == 'vente'
            ), Rule::excludeIf($request->type_annonce == 'location'), 'gt:2'],
            'prix_location' => [Rule::requiredIf($request->type_annonce == 'location'), Rule::excludeIf($request->type_annonce == 'vente'), 'min:1'],
            'disponibilite_vente' => [Rule::requiredIf($request->type_annonce == 'vente'), Rule::excludeIf($request->type_annonce ==
                'location'), Rule::in('vendu', 'disponible', 'indisponible')],
            'disponibilite_location' => [Rule::requiredIf($request->type_annonce == 'location'), Rule::excludeIf($request->type_annonce == 'vente'), Rule::in('louer', 'disponible', 'indisponible')],
        ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        $formElements['etat'] = 'occasion';

        return response()->json($formElements);
    }
}
