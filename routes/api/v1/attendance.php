<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Corp\Attendance\AttendanceController;
use App\Http\Controllers\Api\V1\Corp\Attendance\AttendanceAdjustmentController;
use App\Http\Controllers\Api\V1\Corp\Attendance\AttendancePolicyController;
use App\Http\Controllers\Api\V1\Corp\Attendance\LeaveController;
use Illuminate\Support\Facades\Route;

// ─── Clock In / Out & Summaries ───────────────────────────────────────
Route::post('clock-in', [AttendanceController::class, 'clockIn'])->name('clock-in');
Route::post('clock-out', [AttendanceController::class, 'clockOut'])->name('clock-out');
Route::get('today', [AttendanceController::class, 'today'])->name('today');
Route::get('history', [AttendanceController::class, 'history'])->name('history');

// ─── Leave Requests ──────────────────────────────────────────────────
Route::prefix('leaves')->name('leaves.')->group(function () {
    Route::get('/', [LeaveController::class, 'index'])->name('index');
    Route::post('/', [LeaveController::class, 'store'])->name('store');
    Route::get('{uuid}', [LeaveController::class, 'show'])->name('show');
    Route::put('{uuid}/cancel', [LeaveController::class, 'cancel'])->name('cancel');
    
    // Approval / Rejection (Management level)
    Route::put('{uuid}/approve', [LeaveController::class, 'approve'])->name('approve');
    Route::put('{uuid}/reject', [LeaveController::class, 'reject'])->name('reject');
});

// ─── Attendance Adjustments ─────────────────────────────────────────
Route::prefix('adjustments')->name('adjustments.')->group(function () {
    Route::get('/', [AttendanceAdjustmentController::class, 'index'])->name('index');
    Route::post('/', [AttendanceAdjustmentController::class, 'store'])->name('store');
    Route::put('{uuid}/approve', [AttendanceAdjustmentController::class, 'approve'])->name('approve');
    Route::put('{uuid}/reject', [AttendanceAdjustmentController::class, 'reject'])->name('reject');
});

// ─── Attendance Policy ───────────────────────────────────────────────
Route::prefix('policy')->name('policy.')->group(function () {
    Route::get('/', [AttendancePolicyController::class, 'show'])->name('show');
    Route::put('/', [AttendancePolicyController::class, 'update'])->name('update');
});
