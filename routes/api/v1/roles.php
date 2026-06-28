<?php

use App\Http\Controllers\Api\V1\Rbac\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('permission:roles.view');

    Route::get('roles/permissions', [RoleController::class, 'permissions'])
        ->middleware('permission:roles.view');

    Route::get('roles/{uuid}', [RoleController::class, 'show'])
        ->middleware('permission:roles.view');

    Route::post('roles', [RoleController::class, 'store'])
        ->middleware('permission:roles.create');

    Route::put('roles/{uuid}', [RoleController::class, 'update'])
        ->middleware('permission:roles.edit');

    Route::delete('roles/{uuid}', [RoleController::class, 'destroy'])
        ->middleware('permission:roles.delete');

    Route::put('roles/{uuid}/permissions', [RoleController::class, 'syncPermissions'])
        ->middleware('permission:roles.assign_permissions');
});
