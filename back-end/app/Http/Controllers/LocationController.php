<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request, $data)
    {
        $locations = $request->validate([
            'date_debut' => [
                'required_if:disponibilite_location,louer',
                'date_format:Y-m-d'
            ],
            'date_fin' => ['required_if:disponibilite_location,louer', 'date_format:Y-m-d'],
        ]);

        $dateDebut = Carbon::parse($locations['date_debut']);
        $dateFin = Carbon::parse($locations['date_fin']);

        if ($dateFin->lessThanOrEqualTo($dateDebut)) {
            return response()->json(['errors' => ['date_fin' => ["La date de fin doit être supérieure à la date de début"]]], 422);
        }

        $totalDays = $dateFin->diffInDays($dateDebut);

        Location::create([
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'voiture_id' => $data->id,
            'prix_location' => $data->prix_location,
            'prix_total' => $data->prix_location * $totalDays,
        ]);

        return true;
    }
}
