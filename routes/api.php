<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider or bootstrap/app.php
| within a group which is assigned the "api" middleware group.
|
*/

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    
    // Auth Module Loader
    Route::prefix('auth')->name('auth.')
        ->group(base_path('routes/api/v1/auth.php'));

    // Platform Module Loader
    Route::prefix('platform')->name('platform.')
        ->middleware(['api.platform'])
        ->group(base_path('routes/api/v1/platform.php'));

    // Corporation Module Loader
    Route::prefix('corp')->name('corp.')
        ->middleware(['api.corp'])
        ->group(base_path('routes/api/v1/corporation.php'));
});
