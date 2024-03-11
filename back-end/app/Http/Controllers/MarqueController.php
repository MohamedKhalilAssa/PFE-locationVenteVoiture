<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function index()
    {
        return response(Marque::all(["id", "nom"]))->header('Content-Type', 'application/json');
    }
    public function show($id)
    {
        return response(Marque::find($id))->header('Content-Type', 'application/json');
    }
    public function store(Request $request){
        $formElements = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);
        $marque = Marque::create([
            'nom' => $formElements['nom'],
        ]);
        return response($marque)->header('Content-Type', 'application/json');
    }
    public function update(Request $request, $id)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);
        $marque = Marque::find($id);
        $marque->nom = $formElements['nom'];
        $marque->save();
        return response($marque)->header('Content-Type', 'application/json');
    }
    public function destroy($id)
    {
        $marque = Marque::find($id);
        $marque->delete();
        return response($marque)->header('Content-Type', 'application/json');
    }
}
