<?php

declare(strict_types=1);

namespace App\Services\Notification;

use App\Enums\NotificationPriorityEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Membership\EmployeeProfile;
use App\Models\Notification\AppNotification;
use App\Models\Organization\Department;
use App\Models\Organization\OrganizationMembership;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * The single write path for in-app notifications.
 *
 * Every trigger site goes through here (usually via the `notify_user()` /
 * `notify_users()` helpers) so recipients, dedupe and payload shape stay
 * consistent, and so a notification failure can never break the business
 * operation that raised it.
 */
class NotificationService
{
    /**
     * Create one notification.
     *
     * @param  User|int  $user      recipient, or their id
     * @param  array{
     *     title?: string,
     *     body?: string|null,
     *     organization_id?: int|null,
     *     action_url?: string|null,
     *     subject?: Model|null,
     *     data?: array<string, mixed>,
     *     actor?: User|int|null,
     *     priority?: NotificationPriorityEnum|null,
     *  }  $options
     */
    public function send(User|int $user, NotificationTypeEnum $type, array $options = []): ?AppNotification
    {
        $userId = $user instanceof User ? $user->id : $user;
        $actor = $options['actor'] ?? null;
        $actorId = $actor instanceof User ? $actor->id : $actor;

        // Nobody needs a notification about their own action.
        if ($actorId !== null && $actorId === $userId && ($options['skip_self'] ?? true)) {
            return null;
        }

        $subject = $options['subject'] ?? null;

        try {
            return AppNotification::create([
                'user_id' => $userId,
                'organization_id' => $options['organization_id'] ?? null,
                'type' => $type->value,
                'category' => $type->category(),
                'priority' => ($options['priority'] ?? $type->defaultPriority())->value,
                'title' => $options['title'] ?? $type->defaultTitle(),
                'body' => $options['body'] ?? null,
                'action_url' => $options['action_url'] ?? null,
                'subject_type' => $subject?->getMorphClass(),
                'subject_id' => $subject?->getKey(),
                'data' => $options['data'] ?? null,
                'actor_id' => $actorId,
            ]);
        } catch (\Throwable $e) {
            // A notification must never take down the operation that raised it.
            Log::warning('Failed to create notification', [
                'type' => $type->value,
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Fan out one notification to many recipients, skipping duplicates.
     *
     * @param  iterable<User|int>  $users
     * @param  array<string, mixed>  $options
     * @return Collection<int, AppNotification>
     */
    public function sendMany(iterable $users, NotificationTypeEnum $type, array $options = []): Collection
    {
        $seen = [];
        $created = collect();

        foreach ($users as $user) {
            $userId = $user instanceof User ? $user->id : (int) $user;
            if (isset($seen[$userId])) {
                continue;
            }
            $seen[$userId] = true;

            $notification = $this->send($userId, $type, $options);
            if ($notification !== null) {
                $created->push($notification);
            }
        }

        return $created;
    }

    /**
     * Notify whoever can act on a subordinate's submission: the person's line
     * manager, their department head, and anyone holding the org-wide
     * "approve any" permission for that module.
     *
     * @param  array<string, mixed>  $options
     * @return Collection<int, AppNotification>
     */
    public function sendToApprovers(
        int $subjectUserId,
        int $organizationId,
        SystemPermission $approveAnyPermission,
        NotificationTypeEnum $type,
        array $options = []
    ): Collection {
        $recipients = $this->resolveApproverIds($subjectUserId, $organizationId, $approveAnyPermission);

        return $this->sendMany($recipients, $type, array_merge($options, [
            'organization_id' => $organizationId,
        ]));
    }

    /**
     * @return array<int>
     */
    public function resolveApproverIds(
        int $subjectUserId,
        int $organizationId,
        SystemPermission $approveAnyPermission
    ): array {
        $recipientIds = [];

        $profile = EmployeeProfile::query()
            ->where('user_id', $subjectUserId)
            ->where('organization_id', $organizationId)
            ->first();

        if ($profile?->reports_to !== null) {
            $recipientIds[] = (int) $profile->reports_to;
        }

        if ($profile?->department_id !== null) {
            $headId = Department::query()
                ->where('id', $profile->department_id)
                ->value('head_user_id');

            if ($headId !== null) {
                $recipientIds[] = (int) $headId;
            }
        }

        // Org-wide approvers, resolved through the membership table so we never
        // reach outside the tenant.
        $memberIds = OrganizationMembership::query()
            ->where('organization_id', $organizationId)
            ->pluck('user_id')
            ->all();

        if ($memberIds !== []) {
            setPermissionsTeamId($organizationId);

            try {
                foreach (User::whereIn('id', $memberIds)->get() as $member) {
                    if ($member->hasPermissionTo($approveAnyPermission->value)) {
                        $recipientIds[] = $member->id;
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Failed resolving org-wide approvers', [
                    'organization_id' => $organizationId,
                    'error' => $e->getMessage(),
                ]);
            } finally {
                setPermissionsTeamId(null);
            }
        }

        // The submitter is never their own approver.
        return array_values(array_diff(array_unique($recipientIds), [$subjectUserId]));
    }

    /**
     * Everyone in an organization — for announcements and policy changes.
     *
     * @param  array<string, mixed>  $options
     * @return Collection<int, AppNotification>
     */
    public function sendToOrganization(int $organizationId, NotificationTypeEnum $type, array $options = []): Collection
    {
        $memberIds = OrganizationMembership::query()
            ->where('organization_id', $organizationId)
            ->pluck('user_id')
            ->all();

        return $this->sendMany($memberIds, $type, array_merge($options, [
            'organization_id' => $organizationId,
        ]));
    }

    public function unreadCount(int $userId, ?int $organizationId = null): int
    {
        return AppNotification::query()
            ->where('user_id', $userId)
            ->when($organizationId !== null, fn ($q) => $q->forOrganization($organizationId))
            ->unread()
            ->count();
    }

    /**
     * Mark every unread notification read, optionally only within one workspace.
     *
     * @return int rows affected
     */
    public function markAllAsRead(int $userId, ?int $organizationId = null): int
    {
        return AppNotification::query()
            ->where('user_id', $userId)
            ->when($organizationId !== null, fn ($q) => $q->forOrganization($organizationId))
            ->unread()
            ->update(['read_at' => now()]);
    }
}
