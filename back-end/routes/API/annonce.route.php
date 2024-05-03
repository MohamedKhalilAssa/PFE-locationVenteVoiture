<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;

Route::group(["prefix" => "annonce", 'as' => 'annonce.', "middleware" => ["verifyLocationDate"]], function () {
    // front End material
    Route::get('/{id}', [AnnonceController::class, 'show'])->name("show")->where("id", "[0-9]+");
    // occasion
    Route::post('/occasion', [AnnonceController::class, 'store'])->name("store");
    Route::get('/occasion/pagination', [AnnonceController::class, 'indexOccasion'])->name("indexPaginateOccasion");
    // location
    Route::get('/location/pagination', [AnnonceController::class, 'indexLocation'])->name("indexPaginateLocation");
    // neuf
    Route::get('/neuf/pagination', [AnnonceController::class, 'indexNeuf'])->name("indexPaginateNeuf");
    // getters
    Route::get('/annees', [AnnonceController::class, 'getAnneeFabrication'])->name("getAnneeFabrication");
    Route::get('/location/maxPrice', [AnnonceController::class, 'getMaxPriceLocation'])->name("getMaxPriceLocation");
    Route::get('/occasion/maxPrice', [AnnonceController::class, 'getMaxPriceVenteOccasion'])->name("getMaxPriceVenteOccasion");
    Route::get('/neuf/maxPrice', [AnnonceController::class, 'getMaxPriceVenteNeuf'])->name("getMaxPriceVenteNeuf");
    Route::get('/topVilles', [AnnonceController::class, 'getTopVilles'])->name("getTopVilles");
    Route::get('/topMarques', [AnnonceController::class, 'getTopMarques'])->name("getTopMarques");
    Route::get('/user-annonces', [AnnonceController::class, 'getUserAnnonces'])->name("getUserAnnonces");
    // for deleting
    Route::delete('/{id}', [AnnonceController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // for updating
    Route::post('/{id}', [
        AnnonceController::class, 'update'
    ])->where("id", "[0-9]+")->name("update");
    // annonce status change
    Route::post('/status/{id}', [
        AnnonceController::class, 'updateStatus'
    ])->where("id", "[0-9]+")->name("updateStatus");
    // annonce dispo change
    Route::post('/disponibilite/{id}', [
        AnnonceController::class, 'updateDisponibilite'
    ])->where("id", "[0-9]+")->name("updateDisponibilite");
});
