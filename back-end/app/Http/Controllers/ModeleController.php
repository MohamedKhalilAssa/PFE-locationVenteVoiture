<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Http\Request;

class ModeleController extends Controller
{
    public function showbyMarque($id)
    {
        return response(Marque::find($id)->modeles()->get(["id", "nom"]))->header('Content-Type', 'application/json');
    }
    public function show($id)
    {
        return response()->json(Modele::find($id));
    }
    public function indexBack()
    {
        return response(Modele::paginate(10))->header('Content-Type', 'application/json');
    }
    public function destroy($id)
    {
        $modele = Modele::find($id);
        $modele->delete();
        return response($modele)->header('Content-Type', 'application/json');
    }
    public function store(Request $request)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'marque_id' => ['required', 'integer', "exists:marques,id"],
        ]);
        $modele = Modele::create([
            'nom' => $formElements['nom'],
            'marque_id' => $formElements['marque_id'],
        ]);
        return response($modele)->header('Content-Type', 'application/json');
    }
    public function update(Request $request, $id)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'marque_id' => ['required', 'integer', "exists:marques,id"],
        ]);
        $modele = Modele::find($id);
        if (!$modele) {
            return back()->with("error", "Modele not found");
        }
        $modele->nom = $formElements['nom'];
        $modele->marque_id = $formElements['marque_id'];
        $modele->save();
        return response($modele)->header('Content-Type', 'application/json');
    }
}
