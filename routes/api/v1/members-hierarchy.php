<?php

use App\Http\Controllers\Api\V1\Organization\MemberHierarchyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

    Route::patch('members/{memberUuid}/designation', [MemberHierarchyController::class, 'assignDesignation'])
        ->middleware('permission:members.assign_designation');

    Route::get('members/{memberUuid}/hierarchy', [MemberHierarchyController::class, 'hierarchy'])
        ->middleware('permission:members.view_hierarchy');
});
