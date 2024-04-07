<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\couleursVoiture;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\JsonResponse as HttpFoundationJsonResponse;

class ColorController extends ParentController
{
    public function __construct()
    {
        $this->model = couleursVoiture::class;
        $this->model_name = 'Couleur';
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }
    // store validation
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => 'required|unique:couleurs_voitures,nom|string|regex:/^\D*$/|max:255',
            'Hexadecimal' => 'required|hex_color|max:255',
        ];
    }
    // update validation
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => 'required|string|regex:/^\D*$/|max:255',
            'Hexadecimal' => 'required|hex_color|max:255',
        ];
    }
    public function beforeSaveForUpdate($validator, $current_model)
    {
        $data = $validator->validated();
        $found = couleursVoiture::where('nom', $data['nom'])->first() ?? false;
        if ($found != false && $data['nom'] != $current_model->nom) {
            return  ['error'=>['nom' => ['la couleur existe deja']]];
        } else {
            return $data;
        }
    }
}
