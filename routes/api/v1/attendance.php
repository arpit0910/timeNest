<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceAdjustmentController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendancePolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceEscalationController;
use App\Enums\SystemPermission;
use Illuminate\Support\Facades\Route;

Route::prefix('organization/attendance')
    ->name('attendance.')
    ->middleware(['api.organization'])
    ->group(function (): void {

        // ─── Clock In / Out & Summaries (AttendanceController) ──────────────────
        Route::controller(AttendanceController::class)->group(function () {
            Route::post('clock-in', 'clockIn')->middleware('permission:' . SystemPermission::ATTENDANCE_CREATE->value)->name('clock-in');
            Route::post('clock-out', 'clockOut')->middleware('permission:' . SystemPermission::ATTENDANCE_CREATE->value)->name('clock-out');
            Route::get('today', 'today')->middleware('permission:' . SystemPermission::ATTENDANCE_VIEW->value)->name('today');
            Route::get('history', 'history')->middleware('permission:' . SystemPermission::ATTENDANCE_VIEW->value)->name('history');
        });

        // ─── Attendance Adjustments (AttendanceAdjustmentController) ──────────
        Route::prefix('adjustments')->name('adjustments.')->controller(AttendanceAdjustmentController::class)->group(function () {
            Route::get('/', 'index')->middleware('permission:' . SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW->value)->name('index');
            Route::post('/', 'store')->middleware('permission:' . SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE->value)->name('store');
            Route::put('{uuid}/approve', 'approve')->middleware('permission:' . SystemPermission::ATTENDANCE_APPROVE->value)->name('approve');
            Route::put('{uuid}/reject', 'reject')->middleware('permission:' . SystemPermission::ATTENDANCE_APPROVE->value)->name('reject');
        });

        // ─── Attendance Policy (AttendancePolicyController) ───────────────────
        Route::prefix('policy')->name('policy.')->controller(AttendancePolicyController::class)->group(function () {
            Route::get('/', 'show')->middleware('permission:' . SystemPermission::ATTENDANCE_POLICY_VIEW->value)->name('show');
            Route::put('/', 'update')->middleware('permission:' . SystemPermission::ATTENDANCE_POLICY_MANAGE->value)->name('update');
            Route::get('versions', 'versions')->middleware('permission:' . SystemPermission::ATTENDANCE_POLICY_VIEW->value)->name('versions');
        });

        // ─── Attendance Escalations (AttendanceEscalationController) ───────────
        Route::prefix('escalations')->name('escalations.')->controller(AttendanceEscalationController::class)->group(function () {
            Route::get('/', 'index')->middleware('permission:' . SystemPermission::ATTENDANCE_ESCALATIONS_VIEW->value)->name('index');
            Route::get('{uuid}', 'show')->middleware('permission:' . SystemPermission::ATTENDANCE_ESCALATIONS_VIEW->value)->name('show');
            Route::patch('{uuid}/status', 'updateStatus')->middleware('permission:' . SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE->value)->name('status.update');
        });
    });

// ─── Attendance Policy (legacy, standalone, non-org-scoped) ────────────────
Route::prefix('attendance/policy')
    ->middleware(['api.organization'])
    ->controller(\App\Http\Controllers\Api\Attendance\AttendancePolicyController::class)
    ->group(function (): void {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{uuid}', 'show');
        Route::put('/{uuid}', 'update');
        Route::get('/{uuid}/versions', 'versions');
    });
