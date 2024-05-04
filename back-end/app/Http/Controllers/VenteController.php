<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends ParentController
{
    public function __construct()
    {
        $this->model = Vente::class;
        $this->model_name = 'Vente';
        $this->middleware('auth:sanctum');
        $this->middleware('admin')->except(['storeVente']);
        parent::__construct();
    }
    public function storeVente($data)
    {
        Vente::create([
            'voiture_id' => $data->id,
            'prix_vente' => $data->prix_vente,
        ]);

        return true;
    }
    public function getVenteByMonth()
    {
        return $this->model->selectRaw('COUNT(*) as total_announces, MONTH(created_at) as month')
            ->groupBy('month')
            ->get();
    }
}
