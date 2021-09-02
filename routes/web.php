<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', [App\Http\Controllers\AppController::class, 'index'])->where('any', '.*');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
