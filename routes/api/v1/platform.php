<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Platform\CorporationController;
use Illuminate\Support\Facades\Route;

Route::prefix('corporations')->name('corporations.')
    ->controller(CorporationController::class)
    ->middleware('permission:'.SystemPermission::CorporationsManage->value)
    ->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{corporation_uuid}', 'show')->name('show');
        Route::put('{corporation_uuid}', 'update')->name('update');
    });
