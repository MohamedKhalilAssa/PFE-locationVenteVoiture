<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarqueController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
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
    public function afterSaveForStore($new_model)
    {
        $image = $this->request->file('image') ?? null;
        // adding image to the form
        if ($image) {
            $path = $image->store('images/marques', 'public');
            $new_model->update(['image' => $path]);
        }
    }
    // updating
    public function beforeValidateForUpdate()
    {
        $this->rules = [
            'nom' => ['required', 'string', 'regex:/^\D*$/', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048']
        ];
    }
    public function afterSaveForUpdate($current_model)
    {
        $image = $this->request->file('image') ?? null;
        // adding image to the form
        if ($image) {
            if (strpos($current_model->image, "/assets") != 0)
                Storage::delete('public/' . $current_model->image);
            $path = $image->store('images/marques', 'public');
            $current_model->update(['image' => $path]);
        }
    }
}
