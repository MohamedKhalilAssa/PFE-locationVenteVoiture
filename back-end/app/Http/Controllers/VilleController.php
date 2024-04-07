<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends ParentController
{
    public function __construct()
    {
        $this->model = Ville::class;
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    // Overriding
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => ['required', 'unique:villes,nom', 'regex:/^\D*$/', 'string', 'max:255'],
        ];
    }
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
        ];
    }

}
