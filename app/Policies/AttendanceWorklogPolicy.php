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
}
