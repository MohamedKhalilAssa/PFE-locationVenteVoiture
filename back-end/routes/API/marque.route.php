<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarqueController;

 Route::group(['prefix' => 'marque', 'as' => 'marque.'], function () {
 // only name and id here
 Route::get('/', [MarqueController::class, 'index'])->name("index");
 // all with pagination
 Route::get('/pagination', [MarqueController::class, 'indexPaginate'])->name("indexPaginate");
 // for showing with id
 Route::get('/{id}', [MarqueController::class, 'show'])->where("id", "[0-9]+")->name("show");
 // for updating
 Route::post('/{id}', [MarqueController::class, 'update'])->where("id", "[0-9]+")->name("update");
 // for creating
 Route::post('/', [MarqueController::class, 'store'])->name("store");
 // for deleting
 Route::delete('/{id}', [MarqueController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
 });
