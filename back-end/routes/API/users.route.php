<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
})->name("user.authenticated");

Route::middleware(['auth:sanctum'])->get('/user/token', function (Request $request) { {
        $token = $request->user()->createToken('test');

        return ['token' => $token->plainTextToken];
    }
})->name("user.token");

Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
    // only name and id here based on marque
    //show with id
    Route::get('/{id}', [UserController::class, 'show'])->where("id", "[0-9]+")->name("show");

    // all with pagination
    Route::get('/pagination', [UserController::class, 'indexPaginate'])->name("indexPaginate");
    // for deleting
    Route::delete('/{id}', [UserController::class, 'destroy'])->where("id", "[0-9]+")->name("destroy");
    // for updating
    Route::post('/{id}', [
        UserController::class,
        'update'
    ])->where("id", "[0-9]+")->name("update");
    Route::post('/change-password', [
        UserController::class, 'changePassword'
    ])->name("changePassword");
    // for creating
    Route::post('/', [UserController::class, 'store'])->name("store");
    // getters
    Route::get('/get-chat', [UserController::class, 'getChattedWith'])->name("getChattedWith");
    Route::get('/get-notif', [UserController::class, 'getNotif'])->name("getNotif");
    Route::get('/total', [UserController::class, 'getTotal'])->name("total");
    Route::get('/admin/online', [UserController::class, 'getOnlineAdmins'])->name("admin.online");
});
