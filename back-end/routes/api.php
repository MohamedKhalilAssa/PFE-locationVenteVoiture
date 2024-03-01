<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarqueController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'marque'], function () {
    Route::get('/', [MarqueController::class, 'index'])->name("index");
})->name("marque.");
// Route::get('/modele',[App\Http\Controllers\ModeleController::class,'index']);
// Route::get('/vehicule',[App\Http\Controllers\VehiculeController::class,'index']);
// Route::get('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'show']);
// Route::post('/vehicule',[App\Http\Controllers\VehiculeController::class,'store']);
// Route::put('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'update']);
// Route::delete('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'destroy']);
