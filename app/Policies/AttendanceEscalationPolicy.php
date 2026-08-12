<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\SystemPermission;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Auth\User;
use App\Policies\Concerns\EnsuresSameOrganization;
use App\Policies\Concerns\ResolvesApprovalHierarchy;

final class AttendanceEscalationPolicy
{
    use EnsuresSameOrganization;
    use ResolvesApprovalHierarchy;

    public function view(User $user, AttendanceEscalation $escalation): bool
    {
        if (! $this->sameOrganization($escalation->organization_id)) {
            return false;
        }

        return $this->canViewUser(
            $user,
            $escalation->user_id,
            $escalation->organization_id,
            SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
            SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
        );
    }

    public function resolve(User $user, AttendanceEscalation $escalation): bool
    {
        // Deliberately flat, org-wide — not hierarchy-scoped. Escalations are reviewed by a
        // compliance/HR-style permission tier, not necessarily the target employee's line
        // manager. Permission already enforced by route middleware; this only confirms
        // tenant isolation. Do not add hierarchy scoping here without a product decision.
        return $this->sameOrganization($escalation->organization_id);
    }
}
