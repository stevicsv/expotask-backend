<?php

use Illuminate\Support\Facades\Route;

use Domain\Auth\Controllers\LoginController;
use Domain\Auth\Controllers\LogoutController;
use Domain\Auth\Controllers\RegisterController;

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', RegisterController::class)->name('register');
Route::delete('/logout', LogoutController::class)->middleware('auth:sanctum')->name('logout');
