<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\SystemPermission;
use App\Models\Attendance\AttendanceDay;
use App\Models\Auth\User;
use App\Policies\Concerns\EnsuresSameOrganization;
use App\Policies\Concerns\ResolvesApprovalHierarchy;

final class AttendanceDayPolicy
{
    use EnsuresSameOrganization;
    use ResolvesApprovalHierarchy;

    public function view(User $user, AttendanceDay $attendanceDay): bool
    {
        if (! $this->sameOrganization($attendanceDay->organization_id)) {
            return false;
        }

        if ($attendanceDay->user_id === $user->id) {
            return true;
        }

        if (! $user->hasPermissionTo(SystemPermission::ATTENDANCE_VIEW->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $attendanceDay->user_id,
            $attendanceDay->organization_id,
            SystemPermission::ATTENDANCE_APPROVE,
        );
    }

    public function approve(User $user, AttendanceDay $attendanceDay): bool
    {
        if (! $this->sameOrganization($attendanceDay->organization_id)) {
            return false;
        }

        if (! $user->hasPermissionTo(SystemPermission::ATTENDANCE_APPROVE->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $attendanceDay->user_id,
            $attendanceDay->organization_id,
            SystemPermission::ATTENDANCE_APPROVE,
        );
    }

    /**
     * Every user whose attendance this user may list, for an unfiltered query.
     *
     * Null means "no restriction" (org-wide). Otherwise the caller themselves
     * plus their subordinates — the same shape AttendanceWorklogPolicy uses.
     *
     * @return array<int>|null
     */
    public function viewableUserIds(User $user, int $organizationId): ?array
    {
        if ($user->hasPermissionTo(SystemPermission::ATTENDANCE_APPROVE_ANY->value)
            || $user->can(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            return null;
        }

        $subordinateIds = $this->getSubordinateUserIds($user, $organizationId);

        return array_values(array_unique(array_merge([$user->id], $subordinateIds)));
    }
}
