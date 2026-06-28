<?php

use App\Http\Controllers\Api\V1\Organization\SubDepartmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

    Route::get('sub-departments', [SubDepartmentController::class, 'index'])
        ->middleware('permission:sub_departments.view');

    Route::get('sub-departments/{uuid}', [SubDepartmentController::class, 'show'])
        ->middleware('permission:sub_departments.view');

    Route::post('sub-departments', [SubDepartmentController::class, 'store'])
        ->middleware('permission:sub_departments.create');

    Route::put('sub-departments/{uuid}', [SubDepartmentController::class, 'update'])
        ->middleware('permission:sub_departments.edit');

    Route::delete('sub-departments/{uuid}', [SubDepartmentController::class, 'destroy'])
        ->middleware('permission:sub_departments.delete');
});
