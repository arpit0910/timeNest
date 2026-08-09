<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\EmployeeProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

    Route::get('employee-profiles/{membershipUuid}', [EmployeeProfileController::class, 'show'])
        ->middleware('permission:' . SystemPermission::EMPLOYEE_PROFILE_VIEW->value);

    Route::patch('employee-profiles/{membershipUuid}', [EmployeeProfileController::class, 'update'])
        ->middleware('permission:' . SystemPermission::EMPLOYEE_PROFILE_MANAGE->value);
});
