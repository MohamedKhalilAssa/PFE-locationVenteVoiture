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
    public function update(Request $request, $id)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);
        $ville = Ville::find($id);
        if (!$ville) {
            back()->with("error", "Ville not found");
        }
        $ville->nom = $formElements['nom'];
        if ($ville->save()) {
            return response()->json(['message' => 'Ville modifié avec succès', 'iconColor' => 'blue']);
        } else {
            return back()->with("error", "Processus echoué");
        }
    }
}
