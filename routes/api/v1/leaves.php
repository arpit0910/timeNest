<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\Leave\LeavePolicyController;
use App\Http\Controllers\Api\Leave\LeaveTypeController;
use App\Http\Controllers\Api\V1\Organization\Attendance\LeaveController;
use App\Http\Controllers\Api\V1\Organization\Leave\LeaveRequestController;
use Illuminate\Support\Facades\Route;

// ─── Leave Requests (consolidated) ──────────────────────────────────────
Route::prefix('leave-requests')
    ->middleware(['api.organization'])
    ->controller(LeaveRequestController::class)
    ->group(function (): void {
        // index/show/balances/cancel: self-service, no permission gate needed.
        Route::get('/', 'index');
        Route::post('/', 'store')->middleware('permission:' . SystemPermission::LEAVES_CREATE->value);
        Route::get('/balances', 'balances');
        Route::get('/{uuid}', 'show');
        Route::post('/{uuid}/approve', 'approve')->middleware('permission:' . SystemPermission::LEAVES_APPROVE->value . '|' . SystemPermission::LEAVES_APPROVE_ANY->value);
        Route::post('/{uuid}/reject', 'reject')->middleware('permission:' . SystemPermission::LEAVES_APPROVE->value . '|' . SystemPermission::LEAVES_APPROVE_ANY->value);
        Route::post('/{uuid}/cancel', 'cancel');
    });

// ─── Leave Policy (legacy, standalone) ──────────────────────────────────
Route::prefix('leave/policy')
    ->middleware(['api.organization'])
    ->controller(LeavePolicyController::class)
    ->group(function (): void {
        // Also reachable by leaves.create: applying for leave needs the policy's
        // half-day/advance-notice rules and the type list below, and neither role
        // typically holds leave_policy.view (see OrganizationRolePermissionsSeeder,
        // e.g. SystemRole::EMPLOYEE) — this is read-only, non-sensitive org config.
        Route::get('/', 'index')->middleware('permission:' . SystemPermission::LEAVE_POLICY_VIEW->value . '|' . SystemPermission::LEAVES_CREATE->value);
        Route::post('/', 'store')->middleware('permission:' . SystemPermission::LEAVE_POLICY_MANAGE->value);
        Route::get('/{uuid}', 'show')->middleware('permission:' . SystemPermission::LEAVE_POLICY_VIEW->value);
        Route::put('/{uuid}', 'update')->middleware('permission:' . SystemPermission::LEAVE_POLICY_MANAGE->value);
        Route::get('/{uuid}/versions', 'versions')->middleware('permission:' . SystemPermission::LEAVE_POLICY_VIEW->value);
    });

// ─── Leave Types (legacy, standalone) ───────────────────────────────────
// Gated by LEAVE_POLICY_* -- no dedicated leave-type permission exists.
Route::middleware(['api.organization'])
    ->controller(LeaveTypeController::class)
    ->group(function (): void {
        Route::get('leave/type-codes', 'codes')->middleware('permission:' . SystemPermission::LEAVE_POLICY_VIEW->value);
        // Also reachable by leaves.create — see the matching note on GET leave/policy above.
        Route::get('leave/policy/{policyUuid}/types', 'index')->middleware('permission:' . SystemPermission::LEAVE_POLICY_VIEW->value . '|' . SystemPermission::LEAVES_CREATE->value);
        Route::post('leave/policy/{policyUuid}/types', 'store')->middleware('permission:' . SystemPermission::LEAVE_POLICY_MANAGE->value);
        Route::get('leave/types/{uuid}', 'show')->middleware('permission:' . SystemPermission::LEAVE_POLICY_VIEW->value);
        Route::put('leave/types/{uuid}', 'update')->middleware('permission:' . SystemPermission::LEAVE_POLICY_MANAGE->value);
        Route::patch('leave/types/{uuid}/deactivate', 'deactivate')->middleware('permission:' . SystemPermission::LEAVE_POLICY_MANAGE->value);
        Route::delete('leave/types/{uuid}', 'destroy')->middleware('permission:' . SystemPermission::LEAVE_POLICY_MANAGE->value);
    });

// ─── Organization Leave Requests (LeaveController, deprecated-but-kept) ─
Route::prefix('organization/attendance/leaves')
    ->name('attendance.leaves.')
    ->middleware(['api.organization'])
    ->controller(LeaveController::class)
    ->group(function (): void {
        Route::get('/', 'index')->middleware('permission:' . SystemPermission::LEAVES_VIEW->value)->name('index');
        Route::post('/', 'store')->middleware('permission:' . SystemPermission::LEAVES_CREATE->value)->name('store');
        Route::get('{uuid}', 'show')->middleware('permission:' . SystemPermission::LEAVES_VIEW->value)->name('show');
        Route::patch('{uuid}/status', 'updateStatus')->middleware('permission:' . SystemPermission::LEAVES_APPROVE->value . '|' . SystemPermission::LEAVES_APPROVE_ANY->value)->name('status.update');
    });
