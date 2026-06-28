<?php

use App\Http\Controllers\Api\V1\Organization\DesignationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth', 'organization.access', 'tenant.resolve'])->group(function () {

    Route::get('designations', [DesignationController::class, 'index'])
        ->middleware('permission:designations.view');

    Route::get('designations/{uuid}', [DesignationController::class, 'show'])
        ->middleware('permission:designations.view');

    Route::post('designations', [DesignationController::class, 'store'])
        ->middleware('permission:designations.create');

    Route::put('designations/{uuid}', [DesignationController::class, 'update'])
        ->middleware('permission:designations.edit');

    Route::delete('designations/{uuid}', [DesignationController::class, 'destroy'])
        ->middleware('permission:designations.delete');
});
