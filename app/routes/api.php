<?php

use Illuminate\Support\Facades\Route;

/**
 * Register Auth Routes
 */
Route::as('auth.')
  ->prefix('auth')
  ->group(base_path() . '/domain/Auth/routes.php');
