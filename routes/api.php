<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
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
| Authorization Strategy:
|   - Authentication: jwt.auth (validates JWT, binds JwtContext to container)
|   - Platform guard: platform.access (ensures platform-level JWT context)
|   - Corp guard:     corp.access (ensures corp-level JWT context)
|   - Tenant:         tenant.resolve (loads Corporation, sets Spatie team)
|   - Permissions:    permission:{name} (Spatie permission middleware)
|
| Controllers contain ZERO authorization logic. All access control is
| enforced at the route level through middleware stacks.
|
*/

// API V1
Route::prefix('v1')->name('api.v1.')->group(function () {

    // ─── Authentication Module ───────────────────────────────────
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

        // Protected Routes (Require valid JWT — any guard)
        Route::middleware(['tm.jwt.auth'])->group(function () {
            
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

    // ─── Corporation Module (Tenant-Scoped) ──────────────────────
    // Middleware stack: jwt.auth → corp.access → tenant.resolve
    // Controllers receive tenant via app('tenant.corporation')
    Route::prefix('corp')->name('corp.')
        ->middleware(['tm.jwt.auth', 'corp.access', 'tenant.resolve'])
        ->group(function () {
        
        // Branches
        Route::prefix('branches')->name('branches.')
            ->controller(BranchController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:' . SystemPermission::BranchesView->value)
                    ->name('index');
                Route::post('/', 'store')
                    ->middleware('permission:' . SystemPermission::BranchesCreate->value)
                    ->name('store');
                Route::get('{uuid}', 'show')
                    ->middleware('permission:' . SystemPermission::BranchesView->value)
                    ->name('show');
                Route::put('{uuid}', 'update')
                    ->middleware('permission:' . SystemPermission::BranchesEdit->value)
                    ->name('update');
                Route::delete('{uuid}', 'destroy')
                    ->middleware('permission:' . SystemPermission::BranchesDelete->value)
                    ->name('destroy');
            });

        // Departments
        Route::prefix('departments')->name('departments.')
            ->controller(DepartmentController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:' . SystemPermission::DepartmentsView->value)
                    ->name('index');
                Route::post('/', 'store')
                    ->middleware('permission:' . SystemPermission::DepartmentsCreate->value)
                    ->name('store');
                Route::get('{uuid}', 'show')
                    ->middleware('permission:' . SystemPermission::DepartmentsView->value)
                    ->name('show');
                Route::put('{uuid}', 'update')
                    ->middleware('permission:' . SystemPermission::DepartmentsEdit->value)
                    ->name('update');
                Route::delete('{uuid}', 'destroy')
                    ->middleware('permission:' . SystemPermission::DepartmentsDelete->value)
                    ->name('destroy');
            });

        // Memberships / Employees
        Route::prefix('memberships')->name('memberships.')
            ->controller(MembershipController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:' . SystemPermission::UsersView->value)
                    ->name('index');
                Route::post('/', 'store')
                    ->middleware('permission:' . SystemPermission::UsersManage->value)
                    ->name('store');
                Route::delete('{uuid}', 'destroy')
                    ->middleware('permission:' . SystemPermission::UsersDelete->value)
                    ->name('destroy');
            });
    });

    // ─── Platform Administration Module ──────────────────────────
    // Middleware stack: jwt.auth → platform.access
    // Only platform-guard JWT tokens can access these routes.
    Route::prefix('platform')->name('platform.')
        ->middleware(['tm.jwt.auth', 'platform.access'])
        ->group(function () {
        
        // Corporation Management
        Route::prefix('corporations')->name('corporations.')
            ->controller(CorporationController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:' . SystemPermission::CorporationsManage->value)
                    ->name('index');
                Route::post('/', 'store')
                    ->middleware('permission:' . SystemPermission::CorporationsManage->value)
                    ->name('store');
                Route::get('{uuid}', 'show')
                    ->middleware('permission:' . SystemPermission::CorporationsManage->value)
                    ->name('show');
                Route::put('{uuid}', 'update')
                    ->middleware('permission:' . SystemPermission::CorporationsManage->value)
                    ->name('update');
            });
    });

    // ─── Future Modules (HRMS, Payroll, etc.) ────────────────────
    // Will go here in future phases.

});
