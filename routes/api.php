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

    // Organization Routes
    Route::prefix('organization')
        ->middleware(['api.organization'])
        ->group(base_path('routes/api/v1/organization.php'));

    // Public Invitation Flow Endpoints
    Route::controller(\App\Http\Controllers\Api\V1\Invitation\PublicInvitationController::class)->group(function (): void {
        Route::get('invitations/validate/{token}', 'validateToken')->name('invitations.validate');
        Route::post('invitations/accept', 'accept')->name('invitations.accept');
    });

    // Attendance Policy Routes
    Route::prefix('attendance/policy')
        ->middleware(['auth:api', 'verified', \App\Http\Middleware\EnsureOrganizationAccess::class])
        ->controller(\App\Http\Controllers\Api\Attendance\AttendancePolicyController::class)
        ->group(function (): void {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::get('/{uuid}/versions', 'versions');
        });

    // Leave Policy Routes
    Route::prefix('leave/policy')
        ->middleware(['auth:api', 'verified', \App\Http\Middleware\EnsureOrganizationAccess::class])
        ->controller(\App\Http\Controllers\Api\Leave\LeavePolicyController::class)
        ->group(function (): void {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::get('/{uuid}/versions', 'versions');
        });

    // Leave Type Routes
    Route::middleware(['auth:api', 'verified', \App\Http\Middleware\EnsureOrganizationAccess::class])
        ->controller(\App\Http\Controllers\Api\Leave\LeaveTypeController::class)
        ->group(function (): void {
            Route::get('leave/policy/{policyUuid}/types', 'index');
            Route::post('leave/policy/{policyUuid}/types', 'store');
            Route::get('leave/types/{uuid}', 'show');
            Route::put('leave/types/{uuid}', 'update');
            Route::patch('leave/types/{uuid}/deactivate', 'deactivate');
            Route::delete('leave/types/{uuid}', 'destroy');
        });

    // Worklog Policy Routes
    Route::prefix('worklog/policy')
        ->middleware(['auth:api', 'verified', \App\Http\Middleware\EnsureOrganizationAccess::class])
        ->controller(\App\Http\Controllers\Api\Worklog\WorklogPolicyController::class)
        ->group(function (): void {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::get('/{uuid}/versions', 'versions');
        });
});
