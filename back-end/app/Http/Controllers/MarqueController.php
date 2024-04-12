<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return ['id', 'nom', 'image'];
    }
    // Overriding the before methods to specify rules
    public function beforeValidateForStore()
    {
        $this->rules = [
            'nom' => ['required', 'unique:marques,nom', 'string', 'regex:/^\D*$/', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048']
        ];
    }
    public function beforeSaveForStore($validator)
    {
        $image = $validator->validated()['image'] ?? null;
        // adding image to the form
        if ($image) {
            $path = $image->store('images/marques', 'public');
            $validatedData = $validator->validated();
            $validatedData['image'] = $path;
            $validator->setData($validatedData);

            return $validator->validated();
        }
    }

    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
        ];
    }
}
