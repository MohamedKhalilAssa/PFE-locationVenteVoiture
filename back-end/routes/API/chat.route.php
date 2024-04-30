<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::group(['prefix' => 'chat', 'as' => 'chat.', 'middleware' => ['auth:sanctum']], function () {
    Route::post('send', [MessageController::class, 'store'])->name("store");
});
