<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\SubDepartmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

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
