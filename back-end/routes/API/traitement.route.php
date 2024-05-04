<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenteController;

Route::group(['prefix' => 'vente', 'as' => 'vente.'], function () {
    // for deleting
    Route::delete('/{id}', [VenteController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // all with pagination
    Route::get('/pagination', [VenteController::class, 'indexPaginate'])->name("indexPaginate");
    // byMonth
    Route::get('/byMonth', [VenteController::class, 'getVenteByMonth'])->name("getVenteByMonth");
});
Route::group(['prefix' => 'location', 'as' => 'location.'], function () {
    // for deleting
    Route::delete('/{id}', [LocationController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // all with pagination
    Route::get('/pagination', [LocationController::class, 'indexPaginate'])->name("indexPaginate");
    // byMonth
    Route::get('/byMonth', [LocationController::class, 'getLocationByMonth'])->name("getLocationByMonth");
});
