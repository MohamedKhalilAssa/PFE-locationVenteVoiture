<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
    // only name and id here based on marque
    //show with id
    Route::get('/{id}', [UserController::class, 'show'])->where("id", "[0-9]+")->name("show");

    // all with pagination
    Route::get('/pagination', [UserController::class, 'indexBack'])->name("indexBack");
    // for deleting
    Route::delete('/{id}', [UserController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // for updating
    Route::post('/{id}', [UserController::class, 'update'])->where("id", "[0-9]+")->name("update");
});