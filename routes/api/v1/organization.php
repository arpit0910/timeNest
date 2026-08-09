<?php

declare(strict_types=1);

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
require __DIR__ . '/members-hierarchy.php';
require __DIR__ . '/employee-profiles.php';

// Membership Management
Route::prefix('memberships')->name('memberships.')
    ->group(base_path('routes/api/v1/memberships.php'));

// Invitation Management
Route::prefix('invitations')->name('invitations.')
    ->group(base_path('routes/api/v1/invitations.php'));

// Future Expansion Modularity
Route::prefix('payroll')->name('payroll.')
    ->group(base_path('routes/api/v1/payroll.php'));

Route::prefix('settings')->name('settings.')
    ->group(base_path('routes/api/v1/settings.php'));
