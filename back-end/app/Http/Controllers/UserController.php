<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show']);
        $this->middleware('admin')->except(['show']);
    }
    public function indexBack()
    {
        return response()->json(['PaginateQuery' => User::paginate(10), 'total' => User::count()]);
    }
    public function show($id)
    {
        return response(User::find($id))->header('Content-Type', 'application/json');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'alpha', 'max:255'],
            'prenom' => ['required', 'string', 'alpha', 'max:255'],
            'telephone' => ['required', 'min:10', 'max:10', 'unique:users,telephone', 'regex:/^((06)|(05)){1}[\d]{8}$/'],
            'email' => [
                'required', 'lowercase',
                'email', 'max:255', 'unique:users,email'
            ],
            'role' => ['required', 'in:root,admin,client'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($id);
        if (!$user) {
            return abort(404, 'Utilisateur not found');
        }
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($user->save()) {
            return response()->json(["message" => "Utilisateur modifié avec succès"]);
        } else {
            return abort(400, 'la modification a echoué');
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404, 'Utilisateur not found');
        }
        if ($user->delete()) {
            return response()->json(['message' => 'Utilisateur supprimé avec succès', 'iconColor' => 'red']);
        } else
            return abort(400, 'la suppression a echoué');
    }
}
