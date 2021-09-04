<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;

Auth::routes();

Route::post('/token', [TokenController::class,'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/token/revoke', [TokenController::class, 'destroy']);
});

Route::get('/logout', function() {
    Auth::guard('web')->logout();
});
