<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;

Route::group(["prefix" => "analytics", 'as' => 'analytics.'], function () {
    Route::get('/visitors', [AnalyticsController::class, 'getTotalVisitors'])->name("visitors");

    // getting paginated information
    Route::get('/pagination', [AnalyticsController::class, 'indexPaginate'])->name("indexPaginate");

    // get by id
    Route::get('/{id}', [AnalyticsController::class, 'show'])->where("id", "[0-9]+")->name("show");
});
