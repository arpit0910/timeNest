<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Organization\InvitationController;
use Illuminate\Support\Facades\Route;

Route::controller(InvitationController::class)->group(function (): void {
    Route::get('/', 'index')->middleware('permission:' . SystemPermission::INVITATIONS_VIEW->value)->name('index');
    Route::get('{uuid}', 'show')->middleware('permission:' . SystemPermission::INVITATIONS_VIEW->value)->name('show');
    Route::post('/', 'store')->middleware('permission:' . SystemPermission::INVITATIONS_CREATE->value)->name('store');
    Route::post('{uuid}/revoke', 'revoke')->middleware('permission:' . SystemPermission::INVITATIONS_REVOKE->value)->name('revoke');
    Route::post('{uuid}/resend', 'resend')->middleware('permission:' . SystemPermission::INVITATIONS_RESEND->value)->name('resend');
});
