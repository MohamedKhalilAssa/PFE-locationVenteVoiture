<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends ParentController
{
    public function __construct()
    {
        $this->model = Marque::class;
        $this->model_name = 'Marque';
        $this->middleware('auth:sanctum')->except(['index', 'indexBack', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    // specify columns to be returned from ::all (optional)
    public function indexReturnedColumns()
    {
        return ['id', 'nom'];
    }
    // Overriding the before methods to specify rules
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => ['required', 'unique:marques,nom', 'string', 'regex:/^\D*$/', 'max:255'],
        ];
    }
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
        ];
    }

}
