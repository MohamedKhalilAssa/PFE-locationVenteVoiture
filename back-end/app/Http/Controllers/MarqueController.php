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
    public function indexBack()
    {
        return response(Marque::paginate(10))->header('Content-Type', 'application/json');
    }
    public function show($id)
    {
        return response(Marque::find($id))->header('Content-Type', 'application/json');
    }
    public function store(Request $request)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'unique:marques,nom', 'string', 'regex:/^\D*$/', 'max:255'],
        ]);
        Marque::create([
            'nom' => $formElements['nom'],
        ]);
        return response()->json(['message' => 'Marque crée avec succès']);
    }
    public function update(Request $request, $id)
    {
        $formElements = $request->validate([
            'nom' => ['required',  'string', 'regex:/^\D*$/', 'max:255'],
        ]);
        $marque = Marque::find($id);
        $marque->nom = $formElements['nom'];
        if ($marque->save()) {
            return response()->json(['message' => 'Marque modifié avec succès', 'iconColor' => 'blue']);
        } else {
            return back()->with("error", "Processus echoué");
        }
    }
    public function destroy($id)
    {
        $marque = Marque::find($id);
        if ($marque->delete()) {
            return response()->json(['message' => 'Marque supprimé avec succès', 'iconColor' => 'red']);
        } else
            return back()->with("error", "Processus echoué");
    }
}
