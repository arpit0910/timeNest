<?php

declare(strict_types=1);

namespace App\Actions\Attendance;

use App\Enums\Attendance\WorklogStatus;
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
            
            $latestVersion = \App\Models\Worklog\WorklogPolicyVersion::where('worklog_policy_id', $worklogPolicy->id)->latest('version')->first();
            $worklog->worklog_policy_version_id = $latestVersion?->id;
            
            $approvalFlowValue = $worklogPolicy->approval_flow instanceof \App\Enums\Worklog\ApprovalFlow ? $worklogPolicy->approval_flow->value : (int) $worklogPolicy->approval_flow;
            $worklog->approval_flow_snapshot = $approvalFlowValue;

            $initialStatus = $approvalFlowValue === \App\Enums\Worklog\ApprovalFlow::AUTO->value 
                ? WorklogStatus::AUTO_APPROVED 
                : WorklogStatus::SUBMITTED;

            $worklog->worklog_status = $initialStatus->value;
            $worklog->start_time = $data['start_time'] ?? null;
            $worklog->end_time = $data['end_time'] ?? null;
            $worklog->logged_minutes = $loggedMinutes;
            $worklog->description = $data['description'] ?? null;
            $worklog->justification = $data['justification'] ?? null;
            $worklog->metadata = $data['metadata'] ?? null;
            $worklog->created_by = $user->id;

            if ($initialStatus === WorklogStatus::SUBMITTED) {
                $worklog->submitted_at = now();
                $worklog->submitted_by = $user->id;
            } elseif ($initialStatus === WorklogStatus::AUTO_APPROVED) {
                $worklog->submitted_at = now();
                $worklog->submitted_by = $user->id;
                $worklog->approved_at = now();
            }

            $worklog->save();

            // 5. Determine and assign compliance status
            $complianceStatus = $this->calculationService->determineComplianceStatus($worklog, $worklogPolicy);
            $worklog->update(['compliance_status' => $complianceStatus->value]);

            if ($day->policyVersion?->strict_worklog_enforcement) {
                $statusEnum = $worklog->worklog_status instanceof \BackedEnum ? $worklog->worklog_status->value : $worklog->worklog_status;
                if (in_array($statusEnum, [WorklogStatus::APPROVED->value, WorklogStatus::AUTO_APPROVED->value, WorklogStatus::SUBMITTED->value])) {
                    $day->compliance_status = \App\Enums\AttendanceComplianceStatusEnum::COMPLIANT->value;
                    $day->save();
                }
            }

            // 6. Record status history entry (Initial Submit)
            $worklog->statusHistories()->create([
                'old_status' => WorklogStatus::DRAFT->value,
                'new_status' => $initialStatus->value,
                'changed_by' => $user->id,
                'remarks' => 'Worklog submitted',
            ]);

            // 7. Sync task time consumption record
            $this->consumptionService->syncConsumption($worklog);

            return $worklog->fresh();
        });
    }
}
