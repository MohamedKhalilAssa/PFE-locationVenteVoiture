<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function index()
    {
        return response(Marque::all(["id", "nom"]))->header('Content-Type', 'application/json');
    }
}
