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
     * Determine if a user can view another user's records.
     *  1. Self-view is always allowed.
     *  2. Holding approve_any or platform.full_access bypasses hierarchy.
     *  3. Holding viewPermission AND passing line manager or department head check.
     */
    protected function canViewUser(
        User $actor,
        int $targetUserId,
        int $organizationId,
        SystemPermission $viewPermission,
        SystemPermission $approveAnyPermission = SystemPermission::ATTENDANCE_APPROVE_ANY
    ): bool {
        if ($actor->id === $targetUserId) {
            return true;
        }

        if ($actor->hasPermissionTo($approveAnyPermission->value) || $actor->hasPermissionTo(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            return true;
        }

        if (! $actor->hasPermissionTo($viewPermission->value)) {
            return false;
        }

        return $this->isWithinHierarchy($actor->id, $targetUserId, $organizationId);
    }

    /**
     * Check if actor is direct line manager or department head for target user.
     */
    protected function isWithinHierarchy(int $actorId, int $targetUserId, int $organizationId): bool
    {
        if ($actorId === $targetUserId) {
            return false;
        }

        $targetProfile = EmployeeProfile::query()
            ->where('user_id', $targetUserId)
            ->where('organization_id', $organizationId)
            ->first();

        if (! $targetProfile) {
            return false;
        }

        if ($targetProfile->reports_to !== null && $targetProfile->reports_to === $actorId) {
            return true;
        }

        if ($targetProfile->department_id !== null) {
            $isDepartmentHead = Department::query()
                ->where('id', $targetProfile->department_id)
                ->where('head_user_id', $actorId)
                ->exists();

            if ($isDepartmentHead) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all subordinate user IDs for a manager in an organization (reports_to chain + department head).
     *
     * @return array<int>
     */
    protected function getSubordinateUserIds(User $manager, int $organizationId): array
    {
        $directSubordinateUserIds = EmployeeProfile::query()
            ->where('organization_id', $organizationId)
            ->where('reports_to', $manager->id)
            ->pluck('user_id')
            ->toArray();

        $departmentIds = Department::query()
            ->where('organization_id', $organizationId)
            ->where('head_user_id', $manager->id)
            ->pluck('id')
            ->toArray();

        $departmentSubordinateUserIds = [];
        if (! empty($departmentIds)) {
            $departmentSubordinateUserIds = EmployeeProfile::query()
                ->where('organization_id', $organizationId)
                ->whereIn('department_id', $departmentIds)
                ->pluck('user_id')
                ->toArray();
        }

        $allSubordinates = array_unique(array_merge($directSubordinateUserIds, $departmentSubordinateUserIds));

        return array_values($allSubordinates);
    }

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

        if ($actor->hasPermissionTo($approveAnyPermission->value) || $actor->hasPermissionTo(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            return true;
        }

        return $this->isWithinHierarchy($actor->id, $targetUserId, $organizationId);
    }
}
