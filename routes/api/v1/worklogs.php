<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Organization\Attendance\WorklogPolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceWorklogController;
use App\Enums\SystemPermission;
use Illuminate\Support\Facades\Route;

Route::prefix('organization/attendance')
    ->name('attendance.')
    ->middleware(['api.organization'])
    ->group(function (): void {

        // ─── Worklog Compliance Policy (WorklogPolicyController) ───
        Route::prefix('worklog-policy')->name('worklog-policy.')->controller(WorklogPolicyController::class)->group(function () {
            Route::get('/', 'show')->middleware('permission:' . SystemPermission::WORKLOG_POLICY_VIEW->value)->name('show');
            Route::patch('/', 'update')->middleware('permission:' . SystemPermission::WORKLOG_POLICY_MANAGE->value)->name('update');
            Route::get('versions', 'versions')->middleware('permission:' . SystemPermission::WORKLOG_POLICY_VIEW->value)->name('versions');
        });

        // 🔹 Attendance Worklogs (AttendanceWorklogController) 🔹
        Route::controller(AttendanceWorklogController::class)->group(function () {
            Route::post('days/{dayUuid}/worklogs', 'storeForDay')->middleware('permission:' . SystemPermission::WORKLOG_CREATE->value)->name('days.worklogs.store');
            Route::get('days/{dayUuid}/worklogs', 'forDay')->middleware('permission:' . SystemPermission::WORKLOG_VIEW->value)->name('days.worklogs.index');
            Route::get('worklogs', 'index')->middleware('permission:' . SystemPermission::WORKLOG_VIEW->value)->name('worklogs.index');
            Route::get('worklogs/{uuid}', 'show')->middleware('permission:' . SystemPermission::WORKLOG_VIEW->value)->name('worklogs.show');
            Route::put('worklogs/{uuid}', 'update')->middleware('permission:' . SystemPermission::WORKLOG_CREATE->value)->name('worklogs.update');
            Route::delete('worklogs/{uuid}', 'destroy')->middleware('permission:' . SystemPermission::WORKLOG_CREATE->value)->name('worklogs.destroy');
            Route::post('worklogs/{uuid}/approve', 'approve')->middleware('permission:' . SystemPermission::WORKLOG_APPROVE->value)->name('worklogs.approve');
            Route::post('worklogs/{uuid}/reject', 'reject')->middleware('permission:' . SystemPermission::WORKLOG_APPROVE->value)->name('worklogs.reject');
        });
    });
