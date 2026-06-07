<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceAdjustmentController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendancePolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\WorklogPolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceWorklogController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceEscalationController;
use App\Http\Controllers\Api\V1\Organization\Attendance\LeaveController;
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

// ─── Worklog Compliance Policy (WorklogPolicyController) ───
Route::prefix('worklog-policy')->name('worklog-policy.')->controller(WorklogPolicyController::class)->group(function () {
    Route::get('/', 'show')->name('show');
    Route::patch('/', 'update')->name('update');
});

// ─── Attendance Worklogs (AttendanceWorklogController) ─────────────────
Route::prefix('worklogs')->name('worklogs.')->controller(AttendanceWorklogController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('{uuid}', 'show')->name('show');
    Route::patch('{uuid}', 'update')->name('update');
    Route::patch('{uuid}/status', 'updateStatus')->name('status.update');
    Route::delete('{uuid}', 'destroy')->name('destroy');
});

// ─── Attendance Escalations (AttendanceEscalationController) ───────────
Route::prefix('escalations')->name('escalations.')->controller(AttendanceEscalationController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('{uuid}', 'show')->name('show');
    Route::patch('{uuid}/status', 'updateStatus')->name('status.update');
});
