<?php

declare(strict_types=1);

namespace App\Actions\Attendance;

use App\Enums\WorkflowStatusEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Services\Attendance\AttendanceWorklogCalculationService;
use App\Services\Attendance\WorklogPolicyService;
use App\Services\Attendance\AttendanceWorklogValidationService;
use App\Services\Attendance\TaskConsumptionService;
use Illuminate\Support\Facades\DB;

class UpdateAttendanceWorklogAction
{
    public function __construct(
        private readonly WorklogPolicyService $policyService,
        private readonly AttendanceWorklogValidationService $validationService,
        private readonly AttendanceWorklogCalculationService $calculationService,
        private readonly TaskConsumptionService $consumptionService
    ) {}

    public function execute(AttendanceWorklog $worklog, User $actor, array $data): AttendanceWorklog
    {
        return DB::transaction(function () use ($worklog, $actor, $data) {
            // 1. Check current status block
            if (in_array($worklog->worklog_status, [WorkflowStatusEnum::APPROVED, WorkflowStatusEnum::LOCKED], true)) {
                throw new BusinessRuleViolationException('Cannot update a worklog that is already Approved or Locked.', 'WORKLOG_LOCKED');
            }

            // 2. Validate details
            $day = $worklog->attendanceDay;
            $worklogPolicy = $this->policyService->getWorklogPolicyForOrganization($day->organization);

            $this->validationService->validate($actor, $day, $worklogPolicy, $data, $worklog);

            // 3. Compute values
            $loggedMinutes = $this->calculationService->calculateLoggedMinutes($data);

            // 4. Update the worklog
            $worklog->update([
                'project_id' => $data['project_id'] ?? $worklog->project_id,
                'milestone_id' => $data['milestone_id'] ?? $worklog->milestone_id,
                'task_id' => $data['task_id'] ?? $worklog->task_id,
                'start_time' => $data['start_time'] ?? $worklog->start_time,
                'end_time' => $data['end_time'] ?? $worklog->end_time,
                'logged_minutes' => $loggedMinutes,
                'description' => $data['description'] ?? $worklog->description,
                'justification' => $data['justification'] ?? $worklog->justification,
                'metadata' => array_merge($worklog->metadata ?? [], $data['metadata'] ?? []),
                'updated_by' => $actor->id,
            ]);

            // 5. Determine compliance
            $complianceStatus = $this->calculationService->determineComplianceStatus($worklog, $worklogPolicy);
            $worklog->update(['compliance_status' => $complianceStatus->value]);

            // 6. Sync consumption records
            $this->consumptionService->syncConsumption($worklog);

            return $worklog->fresh();
        });
    }
}
