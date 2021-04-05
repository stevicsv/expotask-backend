<?php

use Illuminate\Support\Facades\Route;
use Domain\Auth\Controllers\TestController;

Route::get('/', TestController::class);
