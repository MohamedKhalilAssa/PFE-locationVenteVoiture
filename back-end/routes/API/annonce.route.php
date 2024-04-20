<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;

Route::group(["prefix" => "annonce", 'as' => 'annonce.'], function () {
    // occasion
    Route::post('/occasion', [AnnonceController::class, 'occasionStore'])->name("store");
    Route::get('/occasion/pagination', [AnnonceController::class, 'indexOccasion'])->name("indexPaginateOccasion");
    // location
    Route::get('/location/pagination', [AnnonceController::class, 'indexLocation'])->name("indexPaginateLocation");
    // neuf
    Route::get('/neuf/pagination', [AnnonceController::class, 'indexNeuf'])->name("indexPaginateNeuf");
    // getters

    Route::get('/annees', [AnnonceController::class, 'getAnneeFabrication'])->name("getAnneeFabrication");
});
