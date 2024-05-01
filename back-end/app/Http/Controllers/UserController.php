<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends ParentController
{
    public function __construct()
    {
        $this->model = User::class;
        $this->model_name = 'Utilisateur';
        $this->middleware('auth:sanctum')->except(['show']);
        $this->middleware('admin')->except(['show', 'changePassword', 'getChattedWith', 'update']);
        parent::__construct();
    }
    public function beforeGetting()
    {
        $this->model->where('role', '!=', 'root');
    }
    public function beforeReturnForShow($data)
    {
        // if ($data->role == 'root') {
        //     abort(403, 'Le compte  root ne peut pas etre affiche');
        // }

        return $data;
    }
    // getters
    public function getOnlineAdmins()
    {
        $adminOnline = User::where('status', 'Online')->whereIn('role', ['admin', 'root'])->get();
        return response()->json(['fetched' => count($adminOnline) > 0 ? count($adminOnline) : 0, 'title' => 'Admins en ligne']);
    }
    // creating
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
            'prenom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
            'telephone' => ['required', 'min:10', 'max:10', 'unique:users,telephone', 'regex:/^((06)|(05)){1}[\d]{8}$/'],
            'email' => ['required', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['in:admin,client'],
        ];
    }

    public function beforeSaveForStore()
    {
        $data = $this->request->all();
        // check if the role has been assigned by root otherwise assign default value
        if (Auth::user()->role != 'root') {
            $data['role'] = 'client';
            return $data;
        } else if ($data['role'] == "root") {
            return ['error' => ['role' => ['le role de root ne peut pas etre affecter']]];
        } else {
            return $data;
        }
    }

    // updating
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
            'prenom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
            'telephone' => ['required', 'min:10', 'max:10', 'regex:/^((06)|(05)){1}[\d]{8}$/'],
            'email' => [
                'required',
                'lowercase',
                'email',
                'max:255',
            ],
            'password' => ['exclude'],
        ];
    }
    public function beforeSaveForUpdate($current_model)
    {
        $data = $this->request->all();
        $foundByEmail = $this->model::where('email', $data['email'])->first() ?? false;
        $foundByPhone =
            $this->model::where('telephone', $data['telephone'])->first() ?? false;

        // checks if the role has been changed by the right person as well as if the email you changed is already set or not (phone too )
        if (Auth::user()->id != $current_model->id && !in_array(Auth::user()->role, ['admin', 'root'])) {
            return ['error' => ['email' => ['Seul ton compte est modifiable']]];
        } else if ($this->request->has('role')) {
            if (Auth::user()->role != 'root' && $data['role'] != $current_model->role) {
                return ['error' => ['role' => ['Seul le root peut changer le role d\'un utilisateur']]];
            } else if ($current_model->role == "root" && $data['role'] != "root") {
                return ['error' => ['role' => ['le role de root ne peut pas etre affecter']]];
            } else {
                return $data;
            }
        } else if ($foundByEmail != false) {
            if ($current_model->email && $data['email'] != $current_model->email) {
                return ['error' => ['email' => ['l\'email existe deja']]];
            }
            return $data;
        } else if ($foundByPhone != false) {
            if ($current_model->telephone && $data['telephone'] != $current_model->telephone) {
                return ['error' => ['telephone' => ['le numero de telephone existe deja']]];
            }
            return $data;
        } else {
            return $data;
        }
    }
    public function changePassword()
    {
        $password = $this->request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = $this->model::find(Auth::user()->id);

        if ($user->update(['password' => Hash::make($password["password"])])) {
            return response()->json(['message' => 'Mot de passe modifié avec succès']);
        }

        return abort(400, 'la modification a echoué');
    }
    // Overriding the index method to return nothing
    public function index()
    {
        return;
    }
    public function getChattedWith()
    {
        $authUserId = Auth::user()->id;

        $users = Message::with('receiver', 'sender')
            ->where('sender_id', $authUserId)->orWhere('receiver_id', $authUserId)->distinct()
            ->get();

        $results = [];
        foreach ($users as $user) {
            if ($user->sender_id == $authUserId) {
                if (!in_array($user->receiver, $results))
                    $results[] = $user->receiver;
            } else {
                if (!in_array($user->sender, $results))
                    $results[] = $user->sender;
            }
        }
        return response()->json(['message' => $results]);
    }
}
