<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function store($data)
    {
        Vente::create([
            'voiture_id' => $data->id,
            'prix_vente' => $data->prix_vente,
        ]);

        return true;
    }
}
