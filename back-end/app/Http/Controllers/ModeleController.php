<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class ModeleController extends Controller
{
    public function show($id)
    {
        return response(Marque::find($id)->modeles()->get(["id", "nom"]))->header('Content-Type', 'application/json');
    }
}
