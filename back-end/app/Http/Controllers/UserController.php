<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = User::class;
        $this->model_name = 'Utilisateur';
        $this->middleware('auth:sanctum')->except(['show']);
        $this->middleware('admin')->except(['show']);
    }
    public function beforeGetting()
    {
        $this->model->where('role', '!=', 'root');
    }
    public function beforeReturnForShow($data)
    {
        if ($data->role == 'root') {
            abort(403, 'Le compte  root ne peut pas etre affiche');
        }

        return $data;
    }
    // getters
    public function getOnlineAdmins()
    {
        $adminOnline = User::where('status', 'Online')->where('role', 'admin')->get();
        return response()->json(['fetched' => count($adminOnline) > 0 ? $adminOnline : 0, 'title' => 'Admins en ligne']);
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
        ];
    }
    public function beforeSaveForUpdate($current_model)
    {
        $data = $this->request->all();
        if (Auth::user()->role != 'root' && $data['role'] != $current_model->role) {
            return ['error' => ['role' => ['Seul le root peut changer le role d\'un utilisateur']]];
        } else if ($current_model->role == "root" && $data['role'] != "root") {
            return ['error' => ['role' => ['le role de root ne peut pas etre affecter']]];
        } else {
            return $data;
        }
    }
    // Overriding the index method to return nothing
    public function index()
    {
        return;
    }
}
