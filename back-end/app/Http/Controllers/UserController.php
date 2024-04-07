<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends ParentController
{
    public function __construct()
    {
        $this->model = User::class;
        $this->middleware('auth:sanctum')->except(['show']);
        $this->middleware('admin')->except(['show']);
    }
    public function beforePaginate($model)
    {
        return $model->where('role', '!=', 'root');
    }
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
    public function afterValidateForUpdate($validator)
    {
        $validator->sometimes(
            'role',
            ['required', 'in:admin,client'],
            function () {
                return Auth::user()->role === 'root';
            }
        );
    }
    public function beforeSaveForUpdate($data, $current_model)
    {
        // check if the role has been changed by an authorized person if not return an error
        if (Auth::user()->role != 'root' && $data->role != $current_model->role) {
            return abort(401, 'Vous ne pouvez pas changer le role d\'un utilisateur');
        } else if ($current_model->role == "root" && $data->role != "root") {
            return abort(401, 'Vous ne pouvez pas changer le role d\'un utilisateur root');
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
