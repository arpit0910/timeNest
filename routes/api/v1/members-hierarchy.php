<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\MemberHierarchyController;
use Illuminate\Support\Facades\Route;

// The enclosing group in routes/api/v1/organization.php already applies
// api.organization (tm.jwt.auth -> jwt.full -> organization.access ->
// tenant.resolve -> throttle). Re-declaring them here ran organization.access
// and tenant.resolve twice per request; `jwt.auth` was also the vendor alias,
// which never binds JwtContext.
Route::group([], function () {

    Route::patch('members/{memberUuid}/designation', [MemberHierarchyController::class, 'assignDesignation'])
        ->middleware('permission:' . SystemPermission::MEMBERS_ASSIGN_DESIGNATION->value);

    Route::get('members/{memberUuid}/hierarchy', [MemberHierarchyController::class, 'hierarchy'])
        ->middleware('permission:' . SystemPermission::MEMBERS_VIEW_HIERARCHY->value);
});
