<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Organization\EmployeeProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

    Route::get('employee-profiles/{membershipUuid}', [EmployeeProfileController::class, 'show'])
        ->middleware('permission:employee_profile.view');

    Route::patch('employee-profiles/{membershipUuid}', [EmployeeProfileController::class, 'update'])
        ->middleware('permission:employee_profile.manage');
});
