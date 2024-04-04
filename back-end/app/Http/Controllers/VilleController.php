<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'indexBack', 'show']);
    }
    public function index()
    {
        return response(Ville::all(["id", "nom"]))->header('Content-Type', 'application/json');
    }
    public function indexBack()
    {
        $sort = request('sort') ?? 'none';
        $search         = request('search');
        $sortColumn = request('sortColumn') ?? 'id';
        if ($search && trim($search) != '') {
            $searchColumn = request('searchColumn') ?? 'nom';
            $query = Ville::where($searchColumn, 'like', $search . '%');
            if ($sort == 'asc' || $sort == 'desc') {
                $result = $query->orderBy($sortColumn, $sort)->paginate(10);
            } else {
                $result = $query->paginate(10);
            }
            return response()->json(['PaginateQuery' => $result, 'total' => Ville::count()]);
        } else {
            if ($sort == 'asc' || $sort == 'desc') {
                $result = Ville::orderBy($sortColumn, $sort)->paginate(10);
            } else {
                $result = Ville::paginate(10);
            }
            return response()->json(['PaginateQuery' => $result, 'total' => Ville::count()]);
        }
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
