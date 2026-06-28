<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceAdjustmentController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceEscalationController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendancePolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\AttendanceWorklogController;
use App\Http\Controllers\Api\V1\Organization\Attendance\WorklogPolicyController;
use App\Http\Controllers\Api\V1\Organization\Attendance\LeaveController;
use App\Http\Controllers\Api\V1\Organization\BranchController;
use App\Http\Controllers\Api\V1\Organization\DepartmentController;
use App\Http\Controllers\Api\V1\Organization\InvitationController;
use App\Http\Controllers\Api\V1\Organization\MembershipController;
use Illuminate\Support\Facades\Route;

// Branch Management
Route::prefix('branches')->name('branches.')
    ->group(base_path('routes/api/v1/branches.php'));

// Department Management
Route::prefix('departments')->name('departments.')
    ->group(base_path('routes/api/v1/departments.php'));

require __DIR__ . '/sub-departments.php';
require __DIR__ . '/designations.php';

// Membership Management
Route::prefix('memberships')->name('memberships.')
    ->group(base_path('routes/api/v1/memberships.php'));

// Invitation Management
Route::prefix('invitations')->name('invitations.')
    ->group(base_path('routes/api/v1/invitations.php'));

// Future Expansion Modularity
Route::prefix('payroll')->name('payroll.')
    ->group(base_path('routes/api/v1/payroll.php'));

Route::prefix('attendance')->name('attendance.')
    ->group(base_path('routes/api/v1/attendance.php'));

Route::prefix('settings')->name('settings.')
    ->group(base_path('routes/api/v1/settings.php'));
