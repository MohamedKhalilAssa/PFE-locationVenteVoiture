<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (request('search')) {
            return response()->json(['PaginateQuery' => User::where('nom', 'like', request('search') . '%')->orWhere('prenom', 'like', request('search') . '%')->orWhere('email', 'like', request('search') . '%')->orWhere('telephone', 'like', request('search') . '%')->paginate(10), 'total' => User::count()]);
        } else {
            return response()->json(['PaginateQuery' => User::paginate(10), 'total' => User::count()]);
        }
    }
    public function show($id)
    {
        return response(User::find($id))->header('Content-Type', 'application/json');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
            'prenom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
            'telephone' => ['required', 'min:10', 'max:10',  'regex:/^((06)|(05)){1}[\d]{8}$/'],
            'email' => [
                'required', 'lowercase',
                'email', 'max:255',
            ],
        ]);
        $validator->sometimes(
            'role',
            ['required', 'in:admin,client'],
            function () {
                // Perform your condition here, for example:
                return Auth::user()->role === 'root';
            }
        );

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
        // check if the role has been changed by an authorized person if not return an error
        if (Auth::user()->role === 'root') {
            $user->role = $request->role;
        } else if (Auth::user()->role != 'root' && $request->role != $user->role) {
            abort(401, 'Vous ne pouvez pas changer le role d\'un utilisateur');
        }
        // saving the changes

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
