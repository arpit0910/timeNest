<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API V1
Route::prefix('v1')->name('api.v1.')->group(function () {

    // --- Authentication Module ---
    Route::prefix('auth')->name('auth.')->group(function () {

        // Public Routes (Rate limited via 'auth' throttle)
        Route::middleware(['throttle:auth'])->group(function () {
            Route::post('login', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'login'])->name('login');
            Route::post('register', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'register'])->name('register');
            Route::post('refresh', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'refresh'])->name('refresh');
            Route::post('verify-email', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'verifyEmail'])->name('verify-email');
            
            // Social Login (Google)
            Route::prefix('google')->name('google.')->group(function () {
                Route::get('redirect', [\App\Http\Controllers\Api\V1\Auth\GoogleOAuthController::class, 'redirect'])->name('redirect');
                Route::get('callback', [\App\Http\Controllers\Api\V1\Auth\GoogleOAuthController::class, 'callback'])->name('callback');
            });
        });

        // Protected Routes (Require valid JWT)
        Route::middleware(['jwt.auth'])->group(function () {
            
            // Core Identity
            Route::get('me', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'me'])->name('me');
            Route::post('change-password', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'changePassword'])->name('change-password');
            Route::post('logout', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'logout'])->name('logout');
            Route::post('logout-all', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'logoutAll'])->name('logout-all');
            
            // Two-Factor Authentication
            Route::post('2fa/verify', [\App\Http\Controllers\Api\V1\Auth\TwoFactorController::class, 'verify'])->name('2fa.verify');

            // Workspace Selection & Switching
            Route::get('workspaces', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'workspaces'])->name('workspaces');
            Route::post('select-corporation', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'selectCorporation'])->name('select-corporation');
            Route::post('switch-corporation', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'switchCorporation'])->name('switch-corporation');
        });
    });

    // --- Core Corporation Module ---
    Route::prefix('corp')->name('corp.')->group(function () {
        
        Route::middleware(['jwt.auth'])->group(function () {
            
            // Branches
            Route::prefix('branches')->name('branches.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\V1\Corp\BranchController::class, 'index'])
                    ->middleware('rbac:branches.view')->name('index');
                Route::post('/', [\App\Http\Controllers\Api\V1\Corp\BranchController::class, 'store'])
                    ->middleware('rbac:branches.create')->name('store');
                Route::get('{uuid}', [\App\Http\Controllers\Api\V1\Corp\BranchController::class, 'show'])
                    ->middleware('rbac:branches.view')->name('show');
                Route::put('{uuid}', [\App\Http\Controllers\Api\V1\Corp\BranchController::class, 'update'])
                    ->middleware('rbac:branches.edit')->name('update');
                Route::delete('{uuid}', [\App\Http\Controllers\Api\V1\Corp\BranchController::class, 'destroy'])
                    ->middleware('rbac:branches.delete')->name('destroy');
            });

            // Departments
            Route::prefix('departments')->name('departments.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\V1\Corp\DepartmentController::class, 'index'])
                    ->middleware('rbac:departments.view')->name('index');
                Route::post('/', [\App\Http\Controllers\Api\V1\Corp\DepartmentController::class, 'store'])
                    ->middleware('rbac:departments.create')->name('store');
                Route::get('{uuid}', [\App\Http\Controllers\Api\V1\Corp\DepartmentController::class, 'show'])
                    ->middleware('rbac:departments.view')->name('show');
                Route::put('{uuid}', [\App\Http\Controllers\Api\V1\Corp\DepartmentController::class, 'update'])
                    ->middleware('rbac:departments.edit')->name('update');
                Route::delete('{uuid}', [\App\Http\Controllers\Api\V1\Corp\DepartmentController::class, 'destroy'])
                    ->middleware('rbac:departments.delete')->name('destroy');
            });

            // Memberships / Employees
            Route::prefix('memberships')->name('memberships.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\V1\Corp\MembershipController::class, 'index'])
                    ->middleware('rbac:users.view')->name('index');
                Route::post('/', [\App\Http\Controllers\Api\V1\Corp\MembershipController::class, 'store'])
                    ->middleware('rbac:users.manage')->name('store');
                Route::delete('{uuid}', [\App\Http\Controllers\Api\V1\Corp\MembershipController::class, 'destroy'])
                    ->middleware('rbac:users.delete')->name('destroy');
            });
        });
    });

    // --- Platform Administration Module ---
    Route::prefix('platform')->name('platform.')->group(function () {
        Route::middleware(['jwt.auth'])->group(function () {
            
            // Corporation Management
            Route::prefix('corporations')->name('corporations.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\V1\Platform\CorporationController::class, 'index'])->name('index');
                Route::post('/', [\App\Http\Controllers\Api\V1\Platform\CorporationController::class, 'store'])->name('store');
                Route::get('{uuid}', [\App\Http\Controllers\Api\V1\Platform\CorporationController::class, 'show'])->name('show');
                Route::put('{uuid}', [\App\Http\Controllers\Api\V1\Platform\CorporationController::class, 'update'])->name('update');
            });

        });
    });

    // --- Future Modules (HRMS, Payroll, etc.) ---
    // Will go here in future phases.

});
