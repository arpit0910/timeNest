<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Corp\Attendance\AttendanceController;
use App\Http\Controllers\Api\V1\Corp\Attendance\AttendanceAdjustmentController;
use App\Http\Controllers\Api\V1\Corp\Attendance\AttendancePolicyController;
use App\Http\Controllers\Api\V1\Corp\Attendance\LeaveController;
use Illuminate\Support\Facades\Route;

// ─── Clock In / Out & Summaries (AttendanceController) ──────────────────
Route::controller(AttendanceController::class)->group(function () {
    Route::post('clock-in', 'clockIn')->name('clock-in');
    Route::post('clock-out', 'clockOut')->name('clock-out');
    Route::get('today', 'today')->name('today');
    Route::get('history', 'history')->name('history');
});

// ─── Leave Requests (LeaveController) ──────────────────────────────────
Route::prefix('leaves')->name('leaves.')->controller(LeaveController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('{uuid}', 'show')->name('show');
    Route::patch('{uuid}/status', 'updateStatus')->name('status.update');
});

// ─── Attendance Adjustments (AttendanceAdjustmentController) ──────────
Route::prefix('adjustments')->name('adjustments.')->controller(AttendanceAdjustmentController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::put('{uuid}/approve', 'approve')->name('approve');
    Route::put('{uuid}/reject', 'reject')->name('reject');
});

// ─── Attendance Policy (AttendancePolicyController) ───────────────────
Route::prefix('policy')->name('policy.')->controller(AttendancePolicyController::class)->group(function () {
    Route::get('/', 'show')->name('show');
    Route::put('/', 'update')->name('update');
});
