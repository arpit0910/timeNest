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
}
