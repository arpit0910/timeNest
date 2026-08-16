<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Platform\PlatformRoleController;
use Illuminate\Support\Facades\Route;

// `tm.jwt.auth` is the app's own JwtAuthenticate — the bare `jwt.auth` alias
// previously used here belongs to the JWT package and never binds JwtContext,
// so neither jwt.full nor platform.access could run. Order is deliberate:
// authenticate → reject temp tokens → confirm platform account → check permission.
Route::middleware([
    'tm.jwt.auth',
    'jwt.full',
    'platform.access',
    'permission:' . SystemPermission::PLATFORM_ROLES_MANAGE->value,
])->group(function () {

    Route::get('platform/roles', [PlatformRoleController::class, 'index']);
    Route::get('platform/roles/{uuid}', [PlatformRoleController::class, 'show']);
    Route::post('platform/roles', [PlatformRoleController::class, 'store']);
    Route::put('platform/roles/{uuid}', [PlatformRoleController::class, 'update']);
    Route::delete('platform/roles/{uuid}', [PlatformRoleController::class, 'destroy']);
    Route::put('platform/roles/{uuid}/permissions', [PlatformRoleController::class, 'syncPermissions']);
});
