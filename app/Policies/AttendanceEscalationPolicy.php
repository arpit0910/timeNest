<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\SystemPermission;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Auth\User;
use App\Policies\Concerns\EnsuresSameOrganization;

final class AttendanceEscalationPolicy
{
    use EnsuresSameOrganization;

    public function view(User $user, AttendanceEscalation $escalation): bool
    {
        if (! $this->sameOrganization($escalation->organization_id)) {
            return false;
        }

        return $user->hasPermissionTo(SystemPermission::ATTENDANCE_ESCALATIONS_VIEW->value);
    }

    public function resolve(User $user, AttendanceEscalation $escalation): bool
    {
        if (! $this->sameOrganization($escalation->organization_id)) {
            return false;
        }

        return $user->hasPermissionTo(SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE->value);
    }
}
