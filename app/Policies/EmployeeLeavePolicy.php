<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\SystemPermission;
use App\Models\Leave\EmployeeLeave;
use App\Models\Auth\User;
use App\Policies\Concerns\EnsuresSameOrganization;
use App\Policies\Concerns\ResolvesApprovalHierarchy;

final class EmployeeLeavePolicy
{
    use EnsuresSameOrganization;
    use ResolvesApprovalHierarchy;

    public function view(User $user, EmployeeLeave $leave): bool
    {
        if (! $this->sameOrganization($leave->organization_id)) {
            return false;
        }

        if ($leave->user_id === $user->id) {
            return true;
        }

        if (! $user->hasPermissionTo(SystemPermission::LeavesView->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $leave->user_id,
            $leave->organization_id,
            SystemPermission::LeavesApproveAny,
        );
    }

    public function approve(User $user, EmployeeLeave $leave): bool
    {
        if (! $this->sameOrganization($leave->organization_id)) {
            return false;
        }

        if (! $user->hasPermissionTo(SystemPermission::LeavesApprove->value)) {
            return false;
        }

        return $this->withinApprovalHierarchy(
            $user,
            $leave->user_id,
            $leave->organization_id,
            SystemPermission::LeavesApproveAny,
        );
    }
}
