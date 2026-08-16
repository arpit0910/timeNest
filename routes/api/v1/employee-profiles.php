<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\EmployeeProfileController;
use Illuminate\Support\Facades\Route;

// The enclosing group in routes/api/v1/organization.php already applies
// api.organization (tm.jwt.auth -> jwt.full -> organization.access ->
// tenant.resolve -> throttle). Re-declaring them here ran organization.access
// and tenant.resolve twice per request; `jwt.auth` was also the vendor alias,
// which never binds JwtContext.
Route::group([], function () {

    Route::get('employee-profiles/{membershipUuid}', [EmployeeProfileController::class, 'show'])
        ->middleware('permission:' . SystemPermission::EMPLOYEE_PROFILE_VIEW->value);

    Route::patch('employee-profiles/{membershipUuid}', [EmployeeProfileController::class, 'update'])
        ->middleware('permission:' . SystemPermission::EMPLOYEE_PROFILE_MANAGE->value);
});
