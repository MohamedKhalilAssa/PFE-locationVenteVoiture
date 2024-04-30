<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::group(['prefix' => 'chat', 'as' => 'chat.'], function () {
    Route::post('messages', [ChatController::class, 'message'])->name("message");
});
