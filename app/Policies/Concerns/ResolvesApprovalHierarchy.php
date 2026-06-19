<?php

declare(strict_types=1);

namespace App\Policies\Concerns;

use App\Enums\SystemPermission;
use App\Models\Membership\EmployeeProfile;
use App\Models\Organization\Department;
use App\Models\Auth\User;

trait ResolvesApprovalHierarchy
{
    /**
     * Resolution order:
     *  1. Self-approval is never allowed, regardless of permissions held.
     *  2. Holding the "approve_any" permission bypasses hierarchy entirely.
     *  3. Direct line-manager match via EmployeeProfile.reports_to.
     *  4. Department-head fallback via Department.head_user_id.
     */
    protected function withinApprovalHierarchy(
        User $actor,
        int $targetUserId,
        int $organizationId,
        SystemPermission $approveAnyPermission
    ): bool {
        if ($actor->id === $targetUserId) {
            return false;
        }

        if ($actor->hasPermissionTo($approveAnyPermission->value)) {
            return true;
        }

        $targetProfile = EmployeeProfile::query()
            ->where('user_id', $targetUserId)
            ->where('organization_id', $organizationId)
            ->first();

        if (! $targetProfile) {
            return false;
        }

        if ($targetProfile->reports_to !== null && $targetProfile->reports_to === $actor->id) {
            return true;
        }

        if ($targetProfile->department_id !== null) {
            $isDepartmentHead = Department::query()
                ->where('id', $targetProfile->department_id)
                ->where('head_user_id', $actor->id)
                ->exists();

            if ($isDepartmentHead) {
                return true;
            }
        }

        return false;
    }
}
