<?php

use Illuminate\Support\Facades\Route;
use Domain\Team\Controllers\StoreTeamController;

Route::post('/', StoreTeamController::class)->name('store');
