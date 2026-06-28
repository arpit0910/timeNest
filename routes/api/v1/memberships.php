<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\MembershipController;
use Illuminate\Support\Facades\Route;

Route::controller(MembershipController::class)->group(function (): void {
    Route::get('/', 'index')->middleware('permission:'.SystemPermission::USERS_VIEW->value)->name('index');
    Route::get('{uuid}', 'show')->middleware('permission:'.SystemPermission::USERS_VIEW->value)->name('show');
    Route::post('/', 'store')->middleware('permission:'.SystemPermission::USERS_MANAGE->value)->name('store');
    Route::patch('{uuid}/role', 'updateRole')->middleware('permission:'.SystemPermission::USERS_MANAGE->value)->name('updateRole');
    Route::delete('{membership_uuid}', 'destroy')->middleware('permission:'.SystemPermission::USERS_DELETE->value)->name('destroy');
});
