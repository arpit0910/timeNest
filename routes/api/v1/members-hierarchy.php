<?php

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\MemberHierarchyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

    Route::patch('members/{memberUuid}/designation', [MemberHierarchyController::class, 'assignDesignation'])
        ->middleware('permission:' . SystemPermission::MEMBERS_ASSIGN_DESIGNATION->value);

    Route::get('members/{memberUuid}/hierarchy', [MemberHierarchyController::class, 'hierarchy'])
        ->middleware('permission:' . SystemPermission::MEMBERS_VIEW_HIERARCHY->value);
});
