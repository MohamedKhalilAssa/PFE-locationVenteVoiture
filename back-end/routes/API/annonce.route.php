<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;

Route::group(["prefix" => "annonce", 'as' => 'annonce'], function () {
    Route::post('/occasion/store', [AnnonceController::class, 'occasionStore'])->name("store");
});
