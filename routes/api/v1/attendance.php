<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceAdjustmentController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendancePolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\WorklogPolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceWorklogController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceEscalationController;
use App\Http\Controllers\Api\V1\Organization\Attendance\LeaveController;
use App\Enums\SystemPermission;
use Illuminate\Support\Facades\Route;

// ─── Clock In / Out & Summaries (AttendanceController) ──────────────────
Route::controller(AttendanceController::class)->group(function () {
    Route::post('clock-in', 'clockIn')->middleware('permission:' . SystemPermission::AttendanceCreate->value)->name('clock-in');
    Route::post('clock-out', 'clockOut')->middleware('permission:' . SystemPermission::AttendanceCreate->value)->name('clock-out');
    Route::get('today', 'today')->middleware('permission:' . SystemPermission::AttendanceView->value)->name('today');
    Route::get('history', 'history')->middleware('permission:' . SystemPermission::AttendanceView->value)->name('history');
});

// ─── Leave Requests (LeaveController) ──────────────────────────────────
Route::prefix('leaves')->name('leaves.')->controller(LeaveController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:' . SystemPermission::LeavesView->value)->name('index');
    Route::post('/', 'store')->middleware('permission:' . SystemPermission::LeavesCreate->value)->name('store');
    Route::get('{uuid}', 'show')->middleware('permission:' . SystemPermission::LeavesView->value)->name('show');
    Route::patch('{uuid}/status', 'updateStatus')->middleware('permission:' . SystemPermission::LeavesApprove->value)->name('status.update');
});

// ─── Attendance Adjustments (AttendanceAdjustmentController) ──────────
Route::prefix('adjustments')->name('adjustments.')->controller(AttendanceAdjustmentController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:' . SystemPermission::AttendanceAdjustmentsView->value)->name('index');
    Route::post('/', 'store')->middleware('permission:' . SystemPermission::AttendanceAdjustmentsCreate->value)->name('store');
    Route::put('{uuid}/approve', 'approve')->middleware('permission:' . SystemPermission::AttendanceApprove->value)->name('approve');
    Route::put('{uuid}/reject', 'reject')->middleware('permission:' . SystemPermission::AttendanceApprove->value)->name('reject');
});

// ─── Attendance Policy (AttendancePolicyController) ───────────────────
Route::prefix('policy')->name('policy.')->controller(AttendancePolicyController::class)->group(function () {
    Route::get('/', 'show')->middleware('permission:' . SystemPermission::AttendancePolicyView->value)->name('show');
    Route::put('/', 'update')->middleware('permission:' . SystemPermission::AttendancePolicyManage->value)->name('update');
});

// ─── Worklog Compliance Policy (WorklogPolicyController) ───
Route::prefix('worklog-policy')->name('worklog-policy.')->controller(WorklogPolicyController::class)->group(function () {
    Route::get('/', 'show')->middleware('permission:' . SystemPermission::WorklogPolicyView->value)->name('show');
    Route::patch('/', 'update')->middleware('permission:' . SystemPermission::WorklogPolicyManage->value)->name('update');
});

// ─── Attendance Worklogs (WorklogController) ─────────────────
Route::controller(\App\Http\Controllers\Api\Attendance\WorklogController::class)->group(function () {
    Route::post('days/{dayUuid}/worklogs', 'storeForDay')->middleware('permission:' . SystemPermission::WorklogCreate->value)->name('days.worklogs.store');
    Route::get('days/{dayUuid}/worklogs', 'forDay')->middleware('permission:' . SystemPermission::WorklogView->value)->name('days.worklogs.index');
    Route::get('worklogs', 'index')->middleware('permission:' . SystemPermission::WorklogView->value)->name('worklogs.index');
    Route::get('worklogs/{uuid}', 'show')->middleware('permission:' . SystemPermission::WorklogView->value)->name('worklogs.show');
    Route::post('worklogs/{uuid}/approve', 'approve')->middleware('permission:' . SystemPermission::WorklogApprove->value)->name('worklogs.approve');
    Route::post('worklogs/{uuid}/reject', 'reject')->middleware('permission:' . SystemPermission::WorklogApprove->value)->name('worklogs.reject');
});

// ─── Attendance Escalations (AttendanceEscalationController) ───────────
Route::prefix('escalations')->name('escalations.')->controller(AttendanceEscalationController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:' . SystemPermission::AttendanceEscalationsView->value)->name('index');
    Route::get('{uuid}', 'show')->middleware('permission:' . SystemPermission::AttendanceEscalationsView->value)->name('show');
    Route::patch('{uuid}/status', 'updateStatus')->middleware('permission:' . SystemPermission::AttendanceEscalationsResolve->value)->name('status.update');
});
