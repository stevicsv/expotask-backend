<?php

use Illuminate\Support\Facades\Route;

/**
 * Register Auth Routes
 */
Route::as('auth.')
  ->prefix('auth')
  ->group(base_path() . '/domain/Auth/routes.php');

/**
 * Register Team Routes
 */
Route::as('team.')
  ->prefix('team')
  ->middleware('auth:sanctum')
  ->group(base_path() . '/domain/Team/routes.php');
