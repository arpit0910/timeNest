<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\BranchController;
use Illuminate\Support\Facades\Route;

Route::controller(BranchController::class)->group(function (): void {
    // Read operations (grouped by BranchesView permission)
    Route::middleware('permission:'.SystemPermission::BRANCHES_VIEW->value)->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::get('{branch_uuid}', 'show')->name('show');
    });

    // Write operations
    Route::post('/', 'store')->middleware('permission:'.SystemPermission::BRANCHES_CREATE->value)->name('store');
    Route::put('{branch_uuid}', 'update')->middleware('permission:'.SystemPermission::BRANCHES_EDIT->value)->name('update');
    Route::delete('{branch_uuid}', 'destroy')->middleware('permission:'.SystemPermission::BRANCHES_DELETE->value)->name('destroy');
});
