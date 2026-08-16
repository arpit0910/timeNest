<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\SystemPermission;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Policies\Concerns\EnsuresSameOrganization;
use App\Policies\Concerns\ResolvesApprovalHierarchy;

final class AttendanceWorklogPolicy
{
    use EnsuresSameOrganization;
    use ResolvesApprovalHierarchy;

    public function view(User $user, AttendanceWorklog $worklog): bool
    {
        if (! $this->sameOrganization($worklog->organization_id)) {
            return false;
        }

        if ($worklog->user_id === $user->id) {
            return true;
        }

        // Permission already enforced by route middleware; here we only scope hierarchy.
        return $this->withinApprovalHierarchy(
            $user,
            $worklog->user_id,
            $worklog->organization_id,
            SystemPermission::WORKLOG_APPROVE_ANY,
        );
    }

    public function approve(User $user, AttendanceWorklog $worklog): bool
    {
        if (! $this->sameOrganization($worklog->organization_id)) {
            return false;
        }

        // Permission already enforced by route middleware; here we only scope hierarchy.
        return $this->withinApprovalHierarchy(
            $user,
            $worklog->user_id,
            $worklog->organization_id,
            SystemPermission::WORKLOG_APPROVE_ANY,
        );
    }

    public function viewableUserIds(User $user, int $organizationId): ?array
    {
        if ($user->hasPermissionTo(SystemPermission::WORKLOG_APPROVE_ANY->value)
            || $user->can(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            return null;
        }

        $subordinateIds = $this->getSubordinateUserIds($user, $organizationId);

        return array_values(array_unique(array_merge([$user->id], $subordinateIds)));
    }
}
