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
    public function indexBack()
    {
        return response(Ville::paginate(10))->header('Content-Type', 'application/json');
    }
    public function show($id)
    {
        return response(Ville::find($id))->header('Content-Type', 'application/json');
    }
}
