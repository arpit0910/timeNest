<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\GoogleOAuthController;
use App\Http\Controllers\Api\V1\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;

// Public auth routes (throttled)
Route::middleware(['throttle:auth'])->group(function (): void {
    Route::controller(AuthController::class)->group(function (): void {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::post('refresh', 'refresh')->name('refresh');
        Route::post('verify-email', 'verifyEmail')->name('verify-email');
        Route::post('resend-verification-email', 'resendVerificationEmail')->name('resend-verification-email');
    });

    Route::prefix('google')->name('google.')->controller(GoogleOAuthController::class)->group(function (): void {
        Route::get('redirect', 'redirect')->name('redirect');
        Route::get('callback', 'callback')->name('callback');
    });

    Route::controller(\App\Http\Controllers\Api\V1\Auth\PasswordResetController::class)
        ->group(function (): void {
            Route::post('forgot-password', 'forgotPassword')->name('password.forgot');
            Route::post('reset-password', 'resetPassword')->name('password.reset');
        });
});

// Full JWT authenticated routes
Route::middleware(['tm.jwt.auth', 'jwt.full'])->controller(AuthController::class)->group(function (): void {
    Route::get('user/profile', 'profile')->name('user.profile');
    Route::post('change-password', 'changePassword')->name('change-password');
    Route::post('logout', 'logout')->name('logout');
    Route::post('logout-all', 'logoutAll')->name('logout-all');
    Route::get('workspaces', 'workspaces')->name('workspaces');
    Route::post('switch-organization', 'switchorganization')->name('switch-organization');
});

Route::middleware(['tm.jwt.auth', 'jwt.full'])
    ->prefix('user/2fa')
    ->name('user.2fa.')
    ->controller(TwoFactorController::class)
    ->group(function (): void {
        Route::get('status', 'status')->name('status');
        Route::post('setup/initiate', 'initiateSetup')->name('setup.initiate');
        Route::post('setup/confirm', 'confirmSetup')->name('setup.confirm');
        Route::post('disable', 'disable')->name('disable');
        Route::post('recovery-codes/regenerate', 'regenerateRecoveryCodes')->name('recovery-codes.regenerate');
    });

// Temporary token / 2FA routes
Route::middleware(['api.temp'])->group(function (): void {
    Route::post('select-organization', [AuthController::class, 'selectorganization'])
        ->middleware('jwt.temp:workspace_selection')
        ->name('select-organization');

    Route::post('2fa/verify', [TwoFactorController::class, 'verify'])
        ->middleware(['jwt.temp:2fa', 'throttle:auth'])
        ->name('2fa.verify');
});
