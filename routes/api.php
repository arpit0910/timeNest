<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Invitation\PublicInvitationController;
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

    // Organization Routes
    Route::prefix('organization')
        ->middleware(['api.organization'])
        ->group(base_path('routes/api/v1/organization.php'));

    // Notification Feed
    Route::prefix('notifications')->name('notifications.')
        ->middleware(['api.organization'])
        ->group(base_path('routes/api/v1/notifications.php'));

    // Public Invitation Flow Endpoints
    Route::controller(PublicInvitationController::class)->group(function (): void {
        Route::get('invitations/validate/{token}', 'validateToken')->name('invitations.validate');
        Route::post('invitations/accept', 'accept')->name('invitations.accept');
    });

    require __DIR__ . '/api/v1/attendance.php';
    require __DIR__ . '/api/v1/leaves.php';
    require __DIR__ . '/api/v1/worklogs.php';
    require __DIR__ . '/api/v1/roles.php';
    require __DIR__ . '/api/v1/platform-roles.php';
});