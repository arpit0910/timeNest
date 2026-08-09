<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\DesignationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

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
