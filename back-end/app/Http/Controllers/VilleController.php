<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    public function __construct()
    {
        $this->model = Ville::class;
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }
    public function index()
    {
        return response(Ville::all(["id", "nom"]))->header('Content-Type', 'application/json');
    }
  
    public function show($id)
    {
        return response(Ville::find($id))->header('Content-Type', 'application/json');
    }
    public function update(Request $request, $id)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
        ]);
        $ville = Ville::find($id);
        if (!$ville) {
            return abort(404, 'Ville not found');
        }
        $ville->nom = $formElements['nom'];
        if ($ville->save()) {
            return response()->json(['message' => 'Ville modifié avec succès', 'iconColor' => 'blue']);
        } else {
            return abort(400, 'la modification a echoué');
        }
    }
    public function store(Request $request)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'unique:villes,nom', 'regex:/^\D*$/', 'string', 'max:255'],
        ]);
        Ville::create([
            'nom' => $formElements['nom'],
        ]);
        return response()->json(['message' => 'Ville crée avec succès']);
    }
    public function destroy($id)
    {
        $ville = Ville::find($id);
        if (!$ville) {
            return abort(404, 'Ville not found');
        }
        if ($ville->delete()) {
            return response()->json(['message' => 'Ville supprimé avec succès', 'iconColor' => 'red']);
        } else
            return abort(400, 'la suppression a echoué');
    }
}
