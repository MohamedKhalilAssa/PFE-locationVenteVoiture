<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\couleursVoiture;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\JsonResponse as HttpFoundationJsonResponse;

class ColorController extends Controller
{

    public function index()
    {
        return response(couleursVoiture::all(["id", "nom"]))->header('Content-Type', 'application/json');
    }
}
