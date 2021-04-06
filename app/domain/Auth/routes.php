<?php

use Illuminate\Support\Facades\Route;

use Domain\Auth\Controllers\LoginController;

Route::post('/login', LoginController::class)->name('login');
