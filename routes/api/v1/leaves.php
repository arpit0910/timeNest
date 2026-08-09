<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use Illuminate\Support\Facades\Route;

// ─── Leave Requests (consolidated) ──────────────────────────────────────
Route::prefix('leave-requests')
    ->middleware(['api.organization'])
    ->controller(\App\Http\Controllers\Api\V1\Organization\Leave\LeaveRequestController::class)
    ->group(function (): void {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/balances', 'balances');
        Route::get('/{uuid}', 'show');
        Route::post('/{uuid}/approve', 'approve');
        Route::post('/{uuid}/reject', 'reject');
        Route::post('/{uuid}/cancel', 'cancel');
    });

// ─── Leave Policy (legacy, standalone) ──────────────────────────────────
Route::prefix('leave/policy')
    ->middleware(['api.organization'])
    ->controller(\App\Http\Controllers\Api\Leave\LeavePolicyController::class)
    ->group(function (): void {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{uuid}', 'show');
        Route::put('/{uuid}', 'update');
        Route::get('/{uuid}/versions', 'versions');
    });

// ─── Leave Types (legacy, standalone) ───────────────────────────────────
Route::middleware(['api.organization'])
    ->controller(\App\Http\Controllers\Api\Leave\LeaveTypeController::class)
    ->group(function (): void {
        Route::get('leave/policy/{policyUuid}/types', 'index');
        Route::post('leave/policy/{policyUuid}/types', 'store');
        Route::get('leave/types/{uuid}', 'show');
        Route::put('leave/types/{uuid}', 'update');
        Route::patch('leave/types/{uuid}/deactivate', 'deactivate');
        Route::delete('leave/types/{uuid}', 'destroy');
    });

// ─── Organization Leave Requests (LeaveController, deprecated-but-kept) ─
Route::prefix('organization/attendance/leaves')
    ->name('attendance.leaves.')
    ->middleware(['api.organization'])
    ->controller(\App\Http\Controllers\Api\V1\Organization\Attendance\LeaveController::class)
    ->group(function (): void {
        Route::get('/', 'index')->middleware('permission:' . SystemPermission::LEAVES_VIEW->value)->name('index');
        Route::post('/', 'store')->middleware('permission:' . SystemPermission::LEAVES_CREATE->value)->name('store');
        Route::get('{uuid}', 'show')->middleware('permission:' . SystemPermission::LEAVES_VIEW->value)->name('show');
        Route::patch('{uuid}/status', 'updateStatus')->middleware('permission:' . SystemPermission::LEAVES_APPROVE->value)->name('status.update');
    });
