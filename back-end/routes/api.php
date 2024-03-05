<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\ModeleController;

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
Route::middleware('XSS')->group(function () {

    Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'marque'], function () {
        // only name and id here
        Route::get('/', [MarqueController::class, 'index'])->name("index");
    })->name("marque.");
    // Route::get('/modele',[App\Http\Controllers\ModeleController::class,'index']);
// Route::get('/vehicule',[App\Http\Controllers\VehiculeController::class,'index']);
// Route::get('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'show']);
// Route::post('/vehicule',[App\Http\Controllers\VehiculeController::class,'store']);
// Route::put('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'update']);
// Route::delete('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'destroy']);

    Route::group(['prefix' => 'modele'], function () {
        // only name and id here
        Route::get('/{marque_id}', [ModeleController::class, 'show'])->where("marque_id", "[0-9]+")->name("show");
    })->name("modele.");
});
