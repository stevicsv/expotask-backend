<?php

use Illuminate\Support\Facades\Route;
use Domain\Team\Controllers\StoreTeamController;
use Domain\Team\Controllers\GetAllTeamsController;

Route::get('/', GetAllTeamsController::class)->name('get');
Route::post('/', StoreTeamController::class)->name('store');