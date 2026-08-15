<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Notification;

use App\Enums\NotificationPriorityEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\SystemPermission;
use App\Exceptions\Business\AuthorizationException;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Notification\NotificationListRequest;
use App\Http\Requests\Notification\SendNotificationRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Auth\User;
use App\Models\Notification\AppNotification;
use App\Models\Organization\OrganizationMembership;
use App\Services\Notification\NotificationService;
use Illuminate\Http\JsonResponse;

/**
 * The signed-in user's own notification feed.
 *
 * Every read and write here is scoped to `auth()->id()` — a notification is
 * addressed to one recipient, so there is no cross-user read path and no
 * hierarchy scoping to apply. `notifications.view` gates the feed itself;
 * raising notifications for *other* people needs send/manage.
 */
class NotificationController extends BaseApiController
{
    public function __construct(
        private readonly NotificationService $notificationService,
    ) {}

    /**
     * Notifications for the caller, newest first.
     */
    public function index(NotificationListRequest $request): JsonResponse
    {
        $filters = $request->validated();

        $query = AppNotification::query()
            ->where('user_id', auth()->id())
            ->with(['actor', 'organization'])
            // Account/security notifications carry no organization and follow
            // the user into whichever workspace is active.
            ->forOrganization(current_organization_id());

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (array_key_exists('unread', $filters) && $filters['unread'] !== null) {
            $request->boolean('unread') ? $query->unread() : $query->read();
        }

        if (isset($filters['priority'])) {
            $query->where('priority', (int) $filters['priority']);
        }

        if (isset($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }

        if (isset($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        $perPage = (int) ($filters['per_page'] ?? 30);

        $notifications = $query->orderByDesc('created_at')->paginate($perPage);

        return $this->success(NotificationResource::collection($notifications)->response()->getData(true));
    }

    /**
     * Unread badge count for the active workspace.
     */
    public function unreadCount(): JsonResponse
    {
        return $this->success([
            'unread_count' => $this->notificationService->unreadCount(
                (int) auth()->id(),
                current_organization_id(),
            ),
        ]);
    }

    public function show(string $uuid): JsonResponse
    {
        $notification = $this->findOwned($uuid);

        return $this->success(new NotificationResource($notification->load(['actor', 'organization'])));
    }

    /**
     * Mark one notification read. Idempotent.
     */
    public function markAsRead(string $uuid): JsonResponse
    {
        $notification = $this->findOwned($uuid);
        $notification->markAsRead();

        return $this->success(new NotificationResource($notification), 'Notification marked as read');
    }

    public function markAsUnread(string $uuid): JsonResponse
    {
        $notification = $this->findOwned($uuid);
        $notification->markAsUnread();

        return $this->success(new NotificationResource($notification), 'Notification marked as unread');
    }

    /**
     * Mark every unread notification in the active workspace read.
     */
    public function markAllAsRead(): JsonResponse
    {
        $updated = $this->notificationService->markAllAsRead(
            (int) auth()->id(),
            current_organization_id(),
        );

        return $this->success(['updated' => $updated], 'All notifications marked as read');
    }

    public function destroy(string $uuid): JsonResponse
    {
        $this->findOwned($uuid)->delete();

        return $this->success(message: 'Notification deleted');
    }

    /**
     * Clear the caller's feed for the active workspace. Only read
     * notifications are removed, so nothing unseen is silently discarded.
     */
    public function destroyAll(): JsonResponse
    {
        $deleted = AppNotification::query()
            ->where('user_id', auth()->id())
            ->forOrganization(current_organization_id())
            ->read()
            ->delete();

        return $this->success(['deleted' => $deleted], 'Read notifications cleared');
    }

    /**
     * Raise a notification for other people.
     *
     * Broadcast to the whole organization needs `notifications.send`; picking
     * named recipients needs `notifications.manage`. Recipients are always
     * validated as members of the active organization.
     */
    public function store(SendNotificationRequest $request): JsonResponse
    {
        $organizationId = current_organization_id();
        $actor = auth()->user();
        $targeted = $request->filled('user_uuids');

        if ($targeted && ! $actor->can(SystemPermission::NOTIFICATIONS_MANAGE->value)) {
            throw new AuthorizationException(
                'You are not allowed to send notifications to specific people.',
                'INSUFFICIENT_SCOPE',
            );
        }

        if (! $targeted && ! $actor->can(SystemPermission::NOTIFICATIONS_SEND->value)) {
            throw new AuthorizationException(
                'You are not allowed to broadcast notifications.',
                'INSUFFICIENT_SCOPE',
            );
        }

        $options = [
            'title' => $request->validated('title'),
            'body' => $request->validated('body'),
            'action_url' => $request->validated('action_url'),
            'actor' => $actor,
            'organization_id' => $organizationId,
            // An announcement addressed to everyone includes the sender.
            'skip_self' => false,
            'priority' => $request->filled('priority')
                ? NotificationPriorityEnum::from((int) $request->validated('priority'))
                : null,
        ];

        $type = $request->filled('type')
            ? NotificationTypeEnum::from($request->validated('type'))
            : NotificationTypeEnum::ANNOUNCEMENT;

        if ($targeted) {
            $recipientIds = User::whereIn('uuid', $request->validated('user_uuids'))->pluck('id')->all();

            // Never let a targeted send reach outside the active tenant.
            $memberIds = OrganizationMembership::query()
                ->where('organization_id', $organizationId)
                ->whereIn('user_id', $recipientIds)
                ->pluck('user_id')
                ->all();

            if ($memberIds === []) {
                throw new AuthorizationException(
                    'None of the selected people are members of this organization.',
                    'INSUFFICIENT_SCOPE',
                );
            }

            $created = $this->notificationService->sendMany($memberIds, $type, $options);
        } else {
            $created = $this->notificationService->sendToOrganization($organizationId, $type, $options);
        }

        return $this->created(['sent' => $created->count()], 'Notification sent');
    }

    /**
     * The type/category catalog, so the client can render filters and icons
     * without hard-coding a list that drifts from the backend.
     */
    public function types(): JsonResponse
    {
        $grouped = collect(NotificationTypeEnum::cases())
            ->groupBy(fn (NotificationTypeEnum $type) => $type->category())
            ->map(fn ($types, $category) => [
                'category' => $category,
                'types' => $types->map(fn (NotificationTypeEnum $type) => [
                    'value' => $type->value,
                    'title' => $type->defaultTitle(),
                    'priority' => $type->defaultPriority()->value,
                ])->values(),
            ])
            ->values();

        return $this->success($grouped);
    }

    /**
     * A notification belongs to exactly one recipient; anyone else gets a 404
     * rather than a 403, so the feed can't be probed for other users' rows.
     */
    private function findOwned(string $uuid): AppNotification
    {
        return AppNotification::where('uuid', $uuid)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    }
}
