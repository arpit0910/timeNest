<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Corp\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::controller(DepartmentController::class)->group(function (): void {
    // Read operations (grouped by DepartmentsView permission)
    Route::middleware('permission:'.SystemPermission::DepartmentsView->value)->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::get('{department_uuid}', 'show')->name('show');
    });

    // Write operations
    Route::post('/', 'store')->middleware('permission:'.SystemPermission::DepartmentsCreate->value)->name('store');
    Route::put('{department_uuid}', 'update')->middleware('permission:'.SystemPermission::DepartmentsEdit->value)->name('update');
    Route::delete('{department_uuid}', 'destroy')->middleware('permission:'.SystemPermission::DepartmentsDelete->value)->name('destroy');
});
