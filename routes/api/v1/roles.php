<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Rbac\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api.organization'])->group(function () {

    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('permission:' . SystemPermission::ROLES_VIEW->value);

    Route::get('roles/permissions', [RoleController::class, 'permissions'])
        ->middleware('permission:' . SystemPermission::ROLES_VIEW->value);

    Route::get('roles/{uuid}', [RoleController::class, 'show'])
        ->middleware('permission:' . SystemPermission::ROLES_VIEW->value);

    Route::post('roles', [RoleController::class, 'store'])
        ->middleware('permission:' . SystemPermission::ROLES_CREATE->value);

    Route::put('roles/{uuid}', [RoleController::class, 'update'])
        ->middleware('permission:' . SystemPermission::ROLES_EDIT->value);

    Route::delete('roles/{uuid}', [RoleController::class, 'destroy'])
        ->middleware('permission:' . SystemPermission::ROLES_DELETE->value);

    Route::put('roles/{uuid}/permissions', [RoleController::class, 'syncPermissions'])
        ->middleware('permission:' . SystemPermission::ROLES_ASSIGN_PERMISSIONS->value);
});
