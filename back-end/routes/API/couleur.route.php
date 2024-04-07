<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;

Route::group(['prefix' => 'couleur', 'as' => 'couleur.'], function () {
    // only name and id here
    Route::get('/', [ColorController::class, 'index'])->name("index");
    // getByID
    Route::get('/{id}', [
        ColorController::class, 'show'
    ])->where("id", "[0-9]+")->name("show");
    // for creating
    Route::post('/', [ColorController::class, 'store'])->name("store");
    //    update
    Route::post('/{id}', [
        ColorController::class, 'update'
    ])->where("id", "[0-9]+")->name("update");
    // for deleting
    Route::delete('/{id}', [ColorController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // all with pagination
    Route::get('/pagination', [ColorController::class, 'indexBack'])->name("indexBack");
});
