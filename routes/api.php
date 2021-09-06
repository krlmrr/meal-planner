<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;

Auth::routes();

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/token', [TokenController::class,'create']);
    Route::post('/token/revoke', [TokenController::class, 'destroy']);
    Route::get('/tokens', [TokenController::class, 'index']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/logout', function() {
    Auth::guard('web')->logout();
});
