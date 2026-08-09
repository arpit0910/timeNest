<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Attendance\AttendanceEscalation;
use App\Models\Auth\User;
use App\Policies\Concerns\EnsuresSameOrganization;

final class AttendanceEscalationPolicy
{
    use EnsuresSameOrganization;

    public function view(User $user, AttendanceEscalation $escalation): bool
    {
        // Permission already enforced by route middleware.
        return $this->sameOrganization($escalation->organization_id);
    }

    public function resolve(User $user, AttendanceEscalation $escalation): bool
    {
        // Permission already enforced by route middleware.
        return $this->sameOrganization($escalation->organization_id);
    }
}
