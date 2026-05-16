<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\GoogleOAuthController;
use App\Http\Controllers\Api\V1\Auth\TwoFactorController;
use App\Http\Controllers\Api\V1\Corp\BranchController;
use App\Http\Controllers\Api\V1\Corp\DepartmentController;
use App\Http\Controllers\Api\V1\Corp\MembershipController;
use App\Http\Controllers\Api\V1\Platform\CorporationController;

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
            
            Route::controller(AuthController::class)->group(function () {
                Route::post('login', 'login')->name('login');
                Route::post('register', 'register')->name('register');
                Route::post('refresh', 'refresh')->name('refresh');
                Route::post('verify-email', 'verifyEmail')->name('verify-email');
            });
            
            // Social Login (Google)
            Route::prefix('google')->name('google.')->controller(GoogleOAuthController::class)->group(function () {
                Route::get('redirect', 'redirect')->name('redirect');
                Route::get('callback', 'callback')->name('callback');
            });
        });

        // Protected Routes (Require valid JWT)
        Route::middleware(['jwt.auth'])->group(function () {
            
            Route::controller(AuthController::class)->group(function () {
                // Core Identity
                Route::get('me', 'me')->name('me');
                Route::post('change-password', 'changePassword')->name('change-password');
                Route::post('logout', 'logout')->name('logout');
                Route::post('logout-all', 'logoutAll')->name('logout-all');
                
                // Workspace Selection & Switching
                Route::get('workspaces', 'workspaces')->name('workspaces');
                Route::post('select-corporation', 'selectCorporation')->name('select-corporation');
                Route::post('switch-corporation', 'switchCorporation')->name('switch-corporation');
            });
            
            // Two-Factor Authentication
            Route::controller(TwoFactorController::class)->group(function () {
                Route::post('2fa/verify', 'verify')->name('2fa.verify');
            });
        });
    });

    // --- Core Corporation Module ---
    Route::prefix('corp')->name('corp.')->middleware(['jwt.auth'])->group(function () {
        
        // Branches
        Route::prefix('branches')->name('branches.')->controller(BranchController::class)->group(function () {
            Route::get('/', 'index')->middleware('rbac:branches.view')->name('index');
            Route::post('/', 'store')->middleware('rbac:branches.create')->name('store');
            Route::get('{uuid}', 'show')->middleware('rbac:branches.view')->name('show');
            Route::put('{uuid}', 'update')->middleware('rbac:branches.edit')->name('update');
            Route::delete('{uuid}', 'destroy')->middleware('rbac:branches.delete')->name('destroy');
        });

        // Departments
        Route::prefix('departments')->name('departments.')->controller(DepartmentController::class)->group(function () {
            Route::get('/', 'index')->middleware('rbac:departments.view')->name('index');
            Route::post('/', 'store')->middleware('rbac:departments.create')->name('store');
            Route::get('{uuid}', 'show')->middleware('rbac:departments.view')->name('show');
            Route::put('{uuid}', 'update')->middleware('rbac:departments.edit')->name('update');
            Route::delete('{uuid}', 'destroy')->middleware('rbac:departments.delete')->name('destroy');
        });

        // Memberships / Employees
        Route::prefix('memberships')->name('memberships.')->controller(MembershipController::class)->group(function () {
            Route::get('/', 'index')->middleware('rbac:users.view')->name('index');
            Route::post('/', 'store')->middleware('rbac:users.manage')->name('store');
            Route::delete('{uuid}', 'destroy')->middleware('rbac:users.delete')->name('destroy');
        });
    });

    // --- Platform Administration Module ---
    Route::prefix('platform')->name('platform.')->middleware(['jwt.auth'])->group(function () {
        
        // Corporation Management
        Route::prefix('corporations')->name('corporations.')->controller(CorporationController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('{uuid}', 'show')->name('show');
            Route::put('{uuid}', 'update')->name('update');
        });
    });

    // --- Future Modules (HRMS, Payroll, etc.) ---
    // Will go here in future phases.

});
