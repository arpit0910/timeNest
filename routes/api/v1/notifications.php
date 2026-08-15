<?php

declare(strict_types=1);

use App\Enums\SystemPermission;
use App\Http\Controllers\Api\V1\Notification\NotificationController;
use Illuminate\Support\Facades\Route;

/**
 * The caller's own notification feed. Every route is scoped to auth()->id()
 * inside the controller, so `notifications.view` gates access to the feed
 * itself rather than to anyone else's rows.
 *
 * Static segments are declared before `{uuid}` so "unread-count" and "types"
 * are never swallowed by the wildcard.
 */
Route::controller(NotificationController::class)->group(function (): void {
    Route::middleware('permission:'.SystemPermission::NOTIFICATIONS_VIEW->value)->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::get('unread-count', 'unreadCount')->name('unread_count');
        Route::get('types', 'types')->name('types');

        Route::post('read-all', 'markAllAsRead')->name('read_all');
        Route::delete('read', 'destroyAll')->name('destroy_read');

        Route::get('{uuid}', 'show')->name('show');
        Route::patch('{uuid}/read', 'markAsRead')->name('read');
        Route::patch('{uuid}/unread', 'markAsUnread')->name('unread');
        Route::delete('{uuid}', 'destroy')->name('destroy');
    });

    // Broadcasting needs notifications.send; targeting named recipients needs
    // notifications.manage. The controller enforces which of the two applies.
    Route::post('/', 'store')
        ->middleware('permission:'.SystemPermission::NOTIFICATIONS_SEND->value.'|'.SystemPermission::NOTIFICATIONS_MANAGE->value)
        ->name('store');
});
