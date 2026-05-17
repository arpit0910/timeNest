<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\GoogleOAuthController;
use App\Http\Controllers\Api\V1\Auth\TwoFactorController;
use App\Http\Controllers\Api\V1\Corp\BranchController;
use App\Http\Controllers\Api\V1\Corp\DepartmentController;
use App\Http\Controllers\Api\V1\Corp\MembershipController;
use App\Http\Controllers\Api\V1\Platform\CorporationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::prefix('auth')->name('auth.')->group(function (): void {
        Route::middleware(['throttle:auth'])->group(function (): void {
            Route::controller(AuthController::class)->group(function (): void {
                Route::post('login', 'login')->name('login');
                Route::post('register', 'register')->name('register');
                Route::post('refresh', 'refresh')->name('refresh');
                Route::post('verify-email', 'verifyEmail')->name('verify-email');
            });

            Route::prefix('google')->name('google.')->controller(GoogleOAuthController::class)->group(function (): void {
                Route::get('redirect', 'redirect')->name('redirect');
                Route::get('callback', 'callback')->name('callback');
            });
        });

        Route::middleware(['tm.jwt.auth', 'jwt.full'])->controller(AuthController::class)->group(function (): void {
            Route::get('me', 'me')->name('me');
            Route::post('change-password', 'changePassword')->name('change-password');
            Route::post('logout', 'logout')->name('logout');
            Route::post('logout-all', 'logoutAll')->name('logout-all');
            Route::get('workspaces', 'workspaces')->name('workspaces');
            Route::post('switch-corporation', 'switchCorporation')->name('switch-corporation');
        });

        Route::middleware(['tm.jwt.auth'])->group(function (): void {
            Route::post('select-corporation', [AuthController::class, 'selectCorporation'])
                ->middleware('jwt.temp:workspace_selection')
                ->name('select-corporation');

            Route::post('2fa/verify', [TwoFactorController::class, 'verify'])
                ->middleware('jwt.temp:2fa')
                ->name('2fa.verify');
        });
    });

    Route::prefix('corp')->name('corp.')
        ->middleware(['tm.jwt.auth', 'jwt.full', 'corp.access', 'tenant.resolve', 'throttle:corp'])
        ->group(function (): void {
            Route::prefix('branches')->name('branches.')
                ->controller(BranchController::class)
                ->group(function (): void {
                    Route::get('/', 'index')
                        ->middleware('permission:'.SystemPermission::BranchesView->value)
                        ->name('index');
                    Route::post('/', 'store')
                        ->middleware('permission:'.SystemPermission::BranchesCreate->value)
                        ->name('store');
                    Route::get('{uuid}', 'show')
                        ->middleware('permission:'.SystemPermission::BranchesView->value)
                        ->name('show');
                    Route::put('{uuid}', 'update')
                        ->middleware('permission:'.SystemPermission::BranchesEdit->value)
                        ->name('update');
                    Route::delete('{uuid}', 'destroy')
                        ->middleware('permission:'.SystemPermission::BranchesDelete->value)
                        ->name('destroy');
                });

            Route::prefix('departments')->name('departments.')
                ->controller(DepartmentController::class)
                ->group(function (): void {
                    Route::get('/', 'index')
                        ->middleware('permission:'.SystemPermission::DepartmentsView->value)
                        ->name('index');
                    Route::post('/', 'store')
                        ->middleware('permission:'.SystemPermission::DepartmentsCreate->value)
                        ->name('store');
                    Route::get('{uuid}', 'show')
                        ->middleware('permission:'.SystemPermission::DepartmentsView->value)
                        ->name('show');
                    Route::put('{uuid}', 'update')
                        ->middleware('permission:'.SystemPermission::DepartmentsEdit->value)
                        ->name('update');
                    Route::delete('{uuid}', 'destroy')
                        ->middleware('permission:'.SystemPermission::DepartmentsDelete->value)
                        ->name('destroy');
                });

            Route::prefix('memberships')->name('memberships.')
                ->controller(MembershipController::class)
                ->group(function (): void {
                    Route::get('/', 'index')
                        ->middleware('permission:'.SystemPermission::UsersView->value)
                        ->name('index');
                    Route::post('/', 'store')
                        ->middleware('permission:'.SystemPermission::UsersManage->value)
                        ->name('store');
                    Route::delete('{uuid}', 'destroy')
                        ->middleware('permission:'.SystemPermission::UsersDelete->value)
                        ->name('destroy');
                });
        });

    Route::prefix('platform')->name('platform.')
        ->middleware(['tm.jwt.auth', 'jwt.full', 'platform.access', 'throttle:platform'])
        ->group(function (): void {
            Route::prefix('corporations')->name('corporations.')
                ->controller(CorporationController::class)
                ->group(function (): void {
                    Route::get('/', 'index')
                        ->middleware('permission:'.SystemPermission::CorporationsManage->value)
                        ->name('index');
                    Route::post('/', 'store')
                        ->middleware('permission:'.SystemPermission::CorporationsManage->value)
                        ->name('store');
                    Route::get('{uuid}', 'show')
                        ->middleware('permission:'.SystemPermission::CorporationsManage->value)
                        ->name('show');
                    Route::put('{uuid}', 'update')
                        ->middleware('permission:'.SystemPermission::CorporationsManage->value)
                        ->name('update');
                });
        });
});
