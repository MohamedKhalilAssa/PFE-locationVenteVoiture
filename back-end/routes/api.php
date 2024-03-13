<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\ModeleController;
use App\Http\Controllers\AnnonceController;

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

    Route::group(['prefix' => 'marque', 'as' => 'marque.'], function () {
        // only name and id here
        Route::get('/', [MarqueController::class, 'index'])->name("index");
        // all
        Route::get('/pagination', [MarqueController::class, 'indexBack'])->name("indexBack");
        // for showing with id
        Route::get('/{id}', [MarqueController::class, 'show'])->where("id", "[0-9]+")->name("show");
        // for updating
        Route::post('/{id}', [MarqueController::class, 'update'])->where("id", "[0-9]+")->name("store");
        // for deleting
        Route::delete('/{id}', [MarqueController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
        // for creating
        Route::post('/', [MarqueController::class, 'store'])->name("store");
    });
    // Route::get('/modele',[App\Http\Controllers\ModeleController::class,'index']);
// Route::get('/vehicule',[App\Http\Controllers\VehiculeController::class,'index']);
// Route::get('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'show']);
// Route::post('/vehicule',[App\Http\Controllers\VehiculeController::class,'store']);
// Route::put('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'update']);
// Route::delete('/vehicule/{id}',[App\Http\Controllers\VehiculeController::class,'destroy']);

    Route::group(['prefix' => 'modele', 'as' => 'modele.'], function () {
        // only name and id here based on marque
        Route::get('/{marque_id}', [ModeleController::class, 'show'])->where("marque_id", "[0-9]+")->name("show");
    });
    // couleur
    Route::group(['prefix' => 'couleur', 'as' => 'couleur.'], function () {
        // only name and id here
        Route::get('/', [ColorController::class, 'index'])->name("index");
    });

    Route::group(['prefix' => 'ville', 'as' => 'ville.'], function () {
        Route::get('/', [VilleController::class, 'index'])->name("index");
    });

    Route::group(["prefix" => "annonce", 'as' => 'annonce'], function () {
        Route::post('/occasion/store', [AnnonceController::class, 'occasionStore'])->name("store");
    });
});
