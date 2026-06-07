<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Platform\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('organizations')->name('organizations.')
    ->controller(OrganizationController::class)
    ->middleware('permission:'.SystemPermission::OrganizationsManage->value)
    ->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{organization_uuid}', 'show')->name('show');
        Route::put('{organization_uuid}', 'update')->name('update');
    });
