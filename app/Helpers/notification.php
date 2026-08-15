<?php

declare(strict_types=1);

use App\Enums\NotificationTypeEnum;
use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Notification\AppNotification;
use App\Services\Notification\NotificationService;
use Illuminate\Support\Collection;

if (! function_exists('notify_user')) {
    /**
     * Raise one in-app notification.
     *
     * Trigger sites call this rather than touching the model directly, so
     * recipient rules and payload shape live in one place. Never throws — a
     * failed notification is logged and swallowed.
     *
     * @param  array<string, mixed>  $options  see NotificationService::send()
     */
    function notify_user(User|int $user, NotificationTypeEnum $type, array $options = []): ?AppNotification
    {
        return app(NotificationService::class)->send($user, $type, $options);
    }
}

if (! function_exists('notify_users')) {
    /**
     * Fan one notification out to several recipients, de-duplicated.
     *
     * @param  iterable<User|int>  $users
     * @param  array<string, mixed>  $options
     * @return Collection<int, AppNotification>
     */
    function notify_users(iterable $users, NotificationTypeEnum $type, array $options = []): Collection
    {
        return app(NotificationService::class)->sendMany($users, $type, $options);
    }
}

if (! function_exists('notify_approvers')) {
    /**
     * Notify whoever can approve for this person: line manager, department
     * head, and holders of the given org-wide "approve any" permission.
     *
     * @param  array<string, mixed>  $options
     * @return Collection<int, AppNotification>
     */
    function notify_approvers(
        int $subjectUserId,
        int $organizationId,
        SystemPermission $approveAnyPermission,
        NotificationTypeEnum $type,
        array $options = []
    ): Collection {
        return app(NotificationService::class)
            ->sendToApprovers($subjectUserId, $organizationId, $approveAnyPermission, $type, $options);
    }
}

if (! function_exists('notify_organization')) {
    /**
     * Notify every member of an organization.
     *
     * @param  array<string, mixed>  $options
     * @return Collection<int, AppNotification>
     */
    function notify_organization(int $organizationId, NotificationTypeEnum $type, array $options = []): Collection
    {
        return app(NotificationService::class)->sendToOrganization($organizationId, $type, $options);
    }
}
