<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    public function index()
    {
        return response(Ville::all(["id", "nom"]))->header('Content-Type', 'application/json');
    }
}
