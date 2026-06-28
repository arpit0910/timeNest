<?php

use App\Http\Controllers\Api\V1\Platform\PlatformRoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'permission:platform.roles.manage'])->group(function () {

    Route::get('platform/roles', [PlatformRoleController::class, 'index']);
    Route::get('platform/roles/{uuid}', [PlatformRoleController::class, 'show']);
    Route::post('platform/roles', [PlatformRoleController::class, 'store']);
    Route::put('platform/roles/{uuid}', [PlatformRoleController::class, 'update']);
    Route::delete('platform/roles/{uuid}', [PlatformRoleController::class, 'destroy']);
    Route::put('platform/roles/{uuid}/permissions', [PlatformRoleController::class, 'syncPermissions']);
});
