<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Http\Request;

class ModeleController extends Controller
{
    public function __construct()
    {
        $this->model = Modele::class;
        $this->middleware('auth:sanctum')->except(['index', 'indexBack', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }
    public function showbyMarque($id)
    {
        return response(Marque::find($id)->modeles()->get(["id", "nom"]))->header('Content-Type', 'application/json');
    }
    public function show($id)
    {
        return response()->json(Modele::find($id));
    }
    public function selectecRelations()
    {
        return [
            'marque' => [
                'id', 'nom'
            ]
        ];
    }   
    // public function indexBack()
    // {
    //     $sort = request('sort') ?? 'none';
    //     $search         = request('search');
    //     $sortColumn = request('sortColumn') ?? 'id';
    //     if ($search && trim($search) != '') {
    //         $searchColumn = request('searchColumn') ?? 'nom';
    //         $query = Modele::where($searchColumn, 'like', $search . '%');
    //         if ($sort == 'asc' || $sort == 'desc') {
    //             $result = $query->orderBy($sortColumn, $sort)->paginate(10);
    //         } else {
    //             $result = $query->paginate(10);
    //         }
    //         return response()->json(['PaginateQuery' => $result, 'total' => Modele::count()]);
    //     } else {
    //         if ($sort == 'asc' || $sort == 'desc') {
    //             $result = Modele::orderBy($sortColumn, $sort)->paginate(10);
    //         } else {
    //             $result = Modele::paginate(10);
    //         }
    //         return response()->json(['PaginateQuery' => $result, 'total' => Modele::count()]);
    //     }
    // }
    public function destroy($id)
    {
        $modele = Modele::find($id);
        if (!$modele) {
            return abort(404, 'Modele not found');
        }
        if ($modele->delete()) {
            return response()->json(['message' => 'Marque supprimé avec succès', 'iconColor' => 'red']);
        } else {
            return abort(400, 'la suppresion a echoué');
        }
    }
    public function store(Request $request)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'unique:modeles,nom', 'string', 'regex:/^[a-zA-Z]{1,}\w*/', 'max:255'],
            'marque_id' => ['required', 'integer', "exists:marques,id"],
        ]);
        Modele::create([
            'nom' => $formElements['nom'],
            'marque_id' => $formElements['marque_id'],
        ]);
        return response()->json(['message' => 'Modele crée avec succès']);
    }
    public function update(Request $request, $id)
    {
        $formElements = $request->validate([
            'nom' => ['required', 'string', 'regex:/^[a-zA-Z]{1,}\w*/', 'max:255'],
            'marque_id' => ['required', 'integer', "exists:marques,id"],
        ]);
        $modele = Modele::find($id);
        if (!$modele) {
            return abort(404, 'Modele not found');
        }
        $modele->nom = $formElements['nom'];
        $modele->marque_id = $formElements['marque_id'];
        if ($modele->save()) {
            return response()->json(['message' => 'Modele modifié avec succès', 'iconColor' => 'blue']);
        } else {
            return abort(400, 'la modification a echoué');
        }
    }
}
