<?php

use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'contact-us', 'as' => 'contact.'], function () {
    // all with pagination
    Route::get('/pagination', [ContactUsController::class, 'indexPaginate'])->name("indexPaginate");
    // for showing with id
    Route::get('/{id}', [ContactUsController::class, 'show'])->where("id", "[0-9]+")->name("show");
    // for creating
    Route::post('/', [ContactUsController::class, 'store'])->name("store");
    // for deleting
    Route::delete('/{id}', [ContactUsController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
});
