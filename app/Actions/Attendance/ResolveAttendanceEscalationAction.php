<?php

declare(strict_types=1);

namespace App\Actions\Attendance;

use App\Models\Attendance\AttendanceEscalation;
use App\Models\Auth\User;
use App\Services\Attendance\AttendanceEscalationService;
use Illuminate\Support\Facades\DB;

class ResolveAttendanceEscalationAction
{
    public function __construct(
        private readonly AttendanceEscalationService $escalationService
    ) {}

    public function execute(
        AttendanceEscalation $escalation,
        User $actor,
        bool $dismiss = false,
        ?string $remarks = null
    ): AttendanceEscalation {
        return DB::transaction(function () use ($escalation, $actor, $dismiss, $remarks) {
            if ($dismiss) {
                return $this->escalationService->dismissEscalation($escalation, $actor, $remarks);
            }

            return $this->escalationService->resolveEscalation($escalation, $actor, $remarks);
        });
    }
}
