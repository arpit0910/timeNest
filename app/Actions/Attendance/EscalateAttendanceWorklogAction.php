<?php

declare(strict_types=1);

namespace App\Actions\Attendance;

use App\Enums\EscalationTypeEnum;
use App\Enums\WorkflowStatusEnum;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Services\Attendance\AttendanceEscalationService;
use App\Services\Attendance\WorklogStatusTransitionService;
use Illuminate\Support\Facades\DB;

class EscalateAttendanceWorklogAction
{
    public function __construct(
        private readonly WorklogStatusTransitionService $transitionService,
        private readonly AttendanceEscalationService $escalationService
    ) {}

    public function execute(
        AttendanceWorklog $worklog,
        User $actor,
        EscalationTypeEnum $escalationType,
        ?string $remarks = null,
        array $metadata = []
    ): AttendanceWorklog {
        return DB::transaction(function () use ($worklog, $actor, $escalationType, $remarks, $metadata) {
            // 1. Transition the worklog status to Escalated
            $this->transitionService->transition(
                $worklog,
                WorkflowStatusEnum::ESCALATED,
                $actor,
                $remarks,
                $metadata
            );

            // 2. Trigger the escalation entry
            $this->escalationService->triggerEscalation(
                $worklog->organization_id,
                $worklog->user_id,
                $escalationType,
                $worklog->attendance_day_id,
                $worklog->id,
                $remarks,
                $metadata
            );

            return $worklog->fresh();
        });
    }
}
