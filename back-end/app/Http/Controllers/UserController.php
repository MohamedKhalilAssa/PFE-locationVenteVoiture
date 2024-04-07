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
        $this->model = User::class;
        $this->model_name = 'Utilisateur';
        $this->middleware('auth:sanctum')->except(['show']);
        $this->middleware('admin')->except(['show']);
    }
    public function beforePaginate($model)
    {
        return $model->where('role', '!=', 'root');
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
    public function beforeSaveForStore($validator)
    {
        $data = $validator->validated();
        $validator->after(function ($validator, $data) {
            // check if the role has been changed by an authorized person if not return an error
            if (Auth::user()->role != 'root' && in_array($data['role'], ['admin', 'client'])) {
                $validator->errors()->add(
                    'role',
                    'Seul le root peut donner un role aux utilisateurs'
                );
                return response()->json(['errors' => $validator->errors()], 422);
            } else if ($data['role'] == "root") {
                $validator->errors()->add(
                    'role',
                    'le role de root ne peut pas etre affecter'
                );
                return response()->json(['errors' => $validator->errors()], 422);
            }
        });
        return $data;
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
    public function beforeSaveForUpdate($validator, $current_model)
    {
        $data = $validator->validated();
        $validator->after(function ($validator, $data, $current_model) {
            // check if the role has been changed by an authorized person if not return an error
            if (Auth::user()->role != 'root' && $data->role != $current_model->role) {
                $validator->errors()->add(
                    'role',
                    'Seul le root peut changer le role d\'un utilisateur'
                );
                return response()->json(['errors' => $validator->errors()], 422);
            } else if ($current_model->role == "root" && $data->role != "root") {
                $validator->errors()->add(
                    'role',
                    'le role de root ne peut pas etre affecter'
                );
                return response()->json(['errors' => $validator->errors()], 422);
            }
        });
        return $data;
    }
    // Overriding the index method to return nothing
    public function index()
    {
        return;
    }
}
