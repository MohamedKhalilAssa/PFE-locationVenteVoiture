<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModeleController;

Route::group(['prefix' => 'modele', 'as' => 'modele.'], function () {
    // only name and id here based on marque
    Route::get('/marque/{marque_id}', [ModeleController::class, 'showbyMarque'])->where("marque_id", "[0-9]+")->name("showByMarque");
    //show with id
    Route::get('/{id}', [ModeleController::class, 'show'])->where("id", "[0-9]+")->name("show");

    // all with pagination

    Route::get('/pagination', [ModeleController::class, 'indexBack'])->name("indexBack");
    // for deleting
    Route::delete('/{id}', [ModeleController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // for creating
    Route::post('/', [ModeleController::class, 'store'])->name("store");
    // for updating
    Route::post('/{id}', [ModeleController::class, 'update'])->where("id", "[0-9]+")->name("update");
});
