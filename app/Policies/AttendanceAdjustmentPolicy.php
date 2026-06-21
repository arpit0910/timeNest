<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\SystemPermission;
use App\Models\Attendance\AttendanceAdjustmentRequest;
use App\Models\Auth\User;
use App\Policies\Concerns\EnsuresSameOrganization;
use App\Policies\Concerns\ResolvesApprovalHierarchy;

final class AttendanceAdjustmentPolicy
{
    use EnsuresSameOrganization;
    use ResolvesApprovalHierarchy;

    public function view(User $user, AttendanceAdjustmentRequest $adjustment): bool
    {
        $organizationId = $adjustment->attendanceDay->organization_id;
        $targetUserId = $adjustment->requested_by;

        if (! $this->sameOrganization($organizationId)) {
            return false;
        }

        if ($targetUserId === $user->id) {
            return true;
        }

        if (! $user->hasPermissionTo(SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $targetUserId,
            $organizationId,
            SystemPermission::ATTENDANCE_APPROVE_ANY,
        );
    }

    public function approve(User $user, AttendanceAdjustmentRequest $adjustment): bool
    {
        $organizationId = $adjustment->attendanceDay->organization_id;
        $targetUserId = $adjustment->requested_by;

        if (! $this->sameOrganization($organizationId)) {
            return false;
        }

        if (! $user->hasPermissionTo(SystemPermission::ATTENDANCE_APPROVE->value)
            && ! $user->hasPermissionTo(SystemPermission::ATTENDANCE_APPROVE_ANY->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $targetUserId,
            $organizationId,
            SystemPermission::ATTENDANCE_APPROVE_ANY,
        );
    }
}
