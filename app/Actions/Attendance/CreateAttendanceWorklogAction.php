<?php

declare(strict_types=1);

namespace App\Actions\Attendance;

use App\Enums\WorkflowStatusEnum;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Services\Attendance\AttendanceWorklogCalculationService;
use App\Services\Attendance\WorklogPolicyService;
use App\Services\Attendance\AttendanceWorklogValidationService;
use App\Services\Attendance\TaskConsumptionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateAttendanceWorklogAction
{
    public function __construct(
        private readonly WorklogPolicyService $policyService,
        private readonly AttendanceWorklogValidationService $validationService,
        private readonly AttendanceWorklogCalculationService $calculationService,
        private readonly TaskConsumptionService $consumptionService
    ) {}

    public function execute(User $user, AttendanceDay $day, array $data): AttendanceWorklog
    {
        return DB::transaction(function () use ($user, $day, $data) {
            // 1. Get worklog policy
            $worklogPolicy = $this->policyService->getWorklogPolicyForOrganization($day->organization);

            // 2. Validate payload details
            $this->validationService->validate($user, $day, $worklogPolicy, $data);

            // 3. Compute values
            $loggedMinutes = $this->calculationService->calculateLoggedMinutes($data);

            // 4. Create the worklog
            $worklog = new AttendanceWorklog();
            $worklog->uuid = (string) Str::uuid();
            $worklog->organization_id = $day->organization_id;
            $worklog->user_id = $user->id;
            $worklog->attendance_day_id = $day->id;
            $worklog->attendance_session_id = $data['attendance_session_id'] ?? null;
            $worklog->project_id = $data['project_id'] ?? null;
            $worklog->milestone_id = $data['milestone_id'] ?? null;
            $worklog->task_id = $data['task_id'] ?? null;
            $worklog->worklog_status = WorkflowStatusEnum::Draft->value;
            $worklog->start_time = $data['start_time'] ?? null;
            $worklog->end_time = $data['end_time'] ?? null;
            $worklog->logged_minutes = $loggedMinutes;
            $worklog->description = $data['description'] ?? null;
            $worklog->justification = $data['justification'] ?? null;
            $worklog->metadata = $data['metadata'] ?? null;
            $worklog->created_by = $user->id;
            $worklog->save();

            // 5. Determine and assign compliance status
            $complianceStatus = $this->calculationService->determineComplianceStatus($worklog, $worklogPolicy);
            $worklog->update(['compliance_status' => $complianceStatus->value]);

            // 6. Record status history entry (Initial Draft)
            $worklog->statusHistories()->create([
                'old_status' => WorkflowStatusEnum::Draft->value,
                'new_status' => WorkflowStatusEnum::Draft->value,
                'changed_by' => $user->id,
                'remarks' => 'Worklog created as Draft',
            ]);

            // 7. Sync task time consumption record
            $this->consumptionService->syncConsumption($worklog);

            return $worklog->fresh();
        });
    }
}
