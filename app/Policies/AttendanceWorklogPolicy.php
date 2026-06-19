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

        if (! $user->hasPermissionTo(SystemPermission::WorklogView->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $worklog->user_id,
            $worklog->organization_id,
            SystemPermission::WorklogApproveAny,
        );
    }

    public function approve(User $user, AttendanceWorklog $worklog): bool
    {
        if (! $this->sameOrganization($worklog->organization_id)) {
            return false;
        }

        if (! $user->hasPermissionTo(SystemPermission::WorklogApprove->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $worklog->user_id,
            $worklog->organization_id,
            SystemPermission::WorklogApproveAny,
        );
    }
}
