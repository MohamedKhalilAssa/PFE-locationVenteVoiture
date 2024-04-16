<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;

Route::group(["prefix" => "annonce", 'as' => 'annonce.'], function () {
    Route::post('/occasion', [AnnonceController::class, 'occasionStore'])->name("store");
    Route::get('/occasion', [AnnonceController::class, 'indexOccasion'])->name("index");
});
