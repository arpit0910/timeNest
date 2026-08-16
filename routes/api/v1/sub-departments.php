<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\SubDepartmentController;
use Illuminate\Support\Facades\Route;

// The enclosing group in routes/api/v1/organization.php already applies
// api.organization (tm.jwt.auth -> jwt.full -> organization.access ->
// tenant.resolve -> throttle). Re-declaring them here ran organization.access
// and tenant.resolve twice per request; `jwt.auth` was also the vendor alias,
// which never binds JwtContext.
Route::group([], function () {

    Route::get('sub-departments', [SubDepartmentController::class, 'index'])
        ->middleware('permission:' . SystemPermission::SUB_DEPARTMENTS_VIEW->value);

    Route::get('sub-departments/{uuid}', [SubDepartmentController::class, 'show'])
        ->middleware('permission:' . SystemPermission::SUB_DEPARTMENTS_VIEW->value);

    Route::post('sub-departments', [SubDepartmentController::class, 'store'])
        ->middleware('permission:' . SystemPermission::SUB_DEPARTMENTS_CREATE->value);

    Route::put('sub-departments/{uuid}', [SubDepartmentController::class, 'update'])
        ->middleware('permission:' . SystemPermission::SUB_DEPARTMENTS_EDIT->value);

    Route::delete('sub-departments/{uuid}', [SubDepartmentController::class, 'destroy'])
        ->middleware('permission:' . SystemPermission::SUB_DEPARTMENTS_DELETE->value);

    Route::patch('sub-departments/{uuid}/head', [SubDepartmentController::class, 'assignHead'])
        ->middleware('permission:' . SystemPermission::SUB_DEPARTMENTS_ASSIGN_HEAD->value);
});
