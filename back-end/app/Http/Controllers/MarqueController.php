<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'indexBack', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }
    public function index()
    {
        return response(Marque::all(["id", "nom"]))->header('Content-Type', 'application/json');
    }
    public function indexBack()
    {
        $sort = request('sort') ?? 'none';
        $search         = request('search');
        $sortColumn = request('sortColumn') ?? 'id';
        if ($search && trim($search) != '') {
            $searchColumn = request('searchColumn') ?? 'nom';
            $query = Marque::where($searchColumn, 'like', $search . '%');

          if ($sort == 'asc' || $sort == 'desc') {
                $result = $query->orderBy($sortColumn, $sort)->paginate(10);
            } else {
                $result = $query->paginate(10);
            }
            return response()->json(['PaginateQuery' => $result, 'total' => Marque::count()]);
        } else {
            if ($sort == 'asc' || $sort == 'desc') {
                $result = Marque::orderBy($sortColumn, $sort)->paginate(10);
            } else {
                $result = Marque::paginate(10);
            }
            return response()->json(['PaginateQuery' => $result, 'total' => Marque::count()]);
        }

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
        if (!$marque) {
            return abort(404, 'Modele not found');
        }
        $marque->nom = $formElements['nom'];
        if ($marque->save()) {
            return response()->json(['message' => 'Marque modifié avec succès', 'iconColor' => 'blue']);
        } else {
            return abort(400, 'la modification a echoué');
        }
    }
    public function destroy($id)
    {
        $marque = Marque::find($id);
        if (!$marque) {
            return abort(404, 'Marque not found');
        }
        if ($marque->delete()) {
            return response()->json(['message' => 'Marque supprimé avec succès', 'iconColor' => 'red']);
        } else
            return abort(400, 'la suppression a echoué');
    }
}
