<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VilleController;

Route::group(['prefix' => 'ville', 'as' => 'ville.'], function () {
    Route::get('/', [VilleController::class, 'index'])->name("index");
    // getByID
    Route::get('/{id}', [
        VilleController::class, 'show'
    ])->where("id", "[0-9]+")->name("show");
    // for creating
    Route::post('/', [VilleController::class, 'store'])->name("store");
    //    update
    Route::post('/{id}', [
        VilleController::class, 'update'
    ])->where("id", "[0-9]+")->name("update");
    // for deleting
    Route::delete('/{id}', [VilleController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // all with pagination
    Route::get('/pagination', [VilleController::class, 'indexPaginate'])->name("indexPaginate");
});
