<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;

Route::group(['prefix' => 'couleur', 'as' => 'couleur.'], function () {
    // only name and id here
    Route::get('/', [ColorController::class, 'index'])->name("index");
});
