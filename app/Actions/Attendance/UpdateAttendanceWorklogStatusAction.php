<?php

declare(strict_types=1);

namespace App\Actions\Attendance;

use App\Enums\WorkflowStatusEnum;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Services\Attendance\WorklogStatusTransitionService;

class UpdateAttendanceWorklogStatusAction
{
    public function __construct(
        private readonly WorklogStatusTransitionService $transitionService
    ) {}

    public function execute(
        AttendanceWorklog $worklog,
        WorkflowStatusEnum $targetStatus,
        User $actor,
        ?string $remarks = null,
        array $metadata = []
    ): AttendanceWorklog {
        return $this->transitionService->transition($worklog, $targetStatus, $actor, $remarks, $metadata);
    }
}
