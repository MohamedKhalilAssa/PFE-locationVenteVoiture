<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::group(['prefix' => 'chat', 'as' => 'chat.', 'middleware' => ['auth:sanctum']], function () {
    Route::post('send', [MessageController::class, 'store'])->name("store");
    Route::get('get-messages/{user_id}', [MessageController::class, 'getMessages'])->where("user_id", "[0-9]+")->name("getMessages");
});
