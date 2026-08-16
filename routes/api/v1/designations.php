<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\DesignationController;
use Illuminate\Support\Facades\Route;

// The enclosing group in routes/api/v1/organization.php already applies
// api.organization (tm.jwt.auth -> jwt.full -> organization.access ->
// tenant.resolve -> throttle). Re-declaring them here ran organization.access
// and tenant.resolve twice per request; `jwt.auth` was also the vendor alias,
// which never binds JwtContext.
Route::group([], function () {

    Route::get('designations', [DesignationController::class, 'index'])
        ->middleware('permission:' . SystemPermission::DESIGNATIONS_VIEW->value);

    Route::get('designations/{uuid}', [DesignationController::class, 'show'])
        ->middleware('permission:' . SystemPermission::DESIGNATIONS_VIEW->value);

    Route::post('designations', [DesignationController::class, 'store'])
        ->middleware('permission:' . SystemPermission::DESIGNATIONS_CREATE->value);

    Route::put('designations/{uuid}', [DesignationController::class, 'update'])
        ->middleware('permission:' . SystemPermission::DESIGNATIONS_EDIT->value);

    Route::delete('designations/{uuid}', [DesignationController::class, 'destroy'])
        ->middleware('permission:' . SystemPermission::DESIGNATIONS_DELETE->value);
});
