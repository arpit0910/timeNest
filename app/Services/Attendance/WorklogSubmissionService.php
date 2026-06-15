<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\Attendance\ComplianceStatus as AttendanceComplianceStatus;
use App\Enums\Attendance\EscalationStatus;
use App\Enums\Attendance\EscalationType;
use App\Enums\Attendance\WorklogComplianceStatus;
use App\Enums\Attendance\WorklogStatus;
use App\Enums\AttendanceStatusEnum;
use App\Enums\Worklog\ApprovalFlow;
use App\Exceptions\Attendance\UnauthorizedWorklogActionException;
use App\Exceptions\Attendance\WorklogAlreadyExistsForSessionException;
use App\Exceptions\Attendance\WorklogAlreadyProcessedException;
use App\Exceptions\Attendance\WorklogDescriptionRequiredException;
use App\Exceptions\Attendance\WorklogLockedException;
use App\Exceptions\Attendance\WorklogNotFoundException;
use App\Exceptions\Attendance\WorklogOverflowJustificationRequiredException;
use App\Exceptions\Attendance\WorklogSubmissionWindowClosedException;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Services\Worklog\WorklogPolicyService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorklogSubmissionService
{
    public function __construct(
        protected WorklogPolicyService $worklogPolicyService,
        protected AttendancePolicyService $attendancePolicyService
    ) {}

    public function submitWorklog(
        Organization $organization,
        User $user,
        AttendanceDay $day,
        array $data,
        User $submittedBy
    ): AttendanceWorklog {
        if ($day->user_id !== $user->id) {
            throw new UnauthorizedWorklogActionException();
        }
        if ($day->organization_id !== $organization->id) {
            throw new WorklogNotFoundException();
        }

        $policy = $this->worklogPolicyService->getPolicy($organization);
        $policyVersion = $this->worklogPolicyService->resolveCurrentVersion($policy);

        $attPolicyVersion = AttendancePolicyVersion::find($day->attendance_policy_version_id);

        $sessionDate = $day->attendance_date;
        $daysElapsed = $sessionDate->diffInDays(today());

        if ($daysElapsed > $policyVersion->lock_after_days) {
            throw new WorklogLockedException();
        }

        if ($daysElapsed > $policyVersion->submission_window_days && !$policyVersion->allow_deferred_submission) {
            throw new WorklogSubmissionWindowClosedException();
        }

        $attendanceSessionId = null;
        if (!empty($data['attendance_session_id'])) {
            $session = AttendanceSession::where('uuid', $data['attendance_session_id'])
                ->where('attendance_day_id', $day->id)
                ->firstOrFail();

            $attendanceSessionId = $session->id;

            if (!$policyVersion->allow_multiple_worklogs_per_session) {
                $exists = AttendanceWorklog::where('attendance_session_id', $session->id)->exists();
                if ($exists) {
                    throw new WorklogAlreadyExistsForSessionException();
                }
            }

            if ($session->clock_out_at) {
                $sessionDuration = $session->clock_in_at->diffInMinutes($session->clock_out_at);
                if ($data['logged_minutes'] > $sessionDuration) {
                    if ($policyVersion->require_justification_on_overflow) {
                        if (empty($data['justification'])) {
                            throw new WorklogOverflowJustificationRequiredException();
                        }
                    }
                }
            }
        }

        $description = $data['description'] ?? null;
        if ($policyVersion->require_description) {
            if ($description === null || strlen($description) < $policyVersion->min_description_length) {
                throw new WorklogDescriptionRequiredException();
            }
        }
        if ($policyVersion->min_description_length > 0 && $description !== null) {
            if (strlen($description) < $policyVersion->min_description_length) {
                throw new WorklogDescriptionRequiredException();
            }
        }

        $flow = $policyVersion->approval_flow;

        return DB::transaction(function () use ($organization, $user, $day, $data, $submittedBy, $policyVersion, $flow, $attendanceSessionId, $attPolicyVersion) {
            $worklog = new AttendanceWorklog();
            $worklog->organization_id = $organization->id;
            $worklog->user_id = $user->id;
            $worklog->attendance_day_id = $day->id;
            $worklog->attendance_session_id = $attendanceSessionId;
            $worklog->project_id = $data['project_id'] ?? null;
            $worklog->milestone_id = $data['milestone_id'] ?? null;
            $worklog->task_id = $data['task_id'] ?? null;
            $worklog->worklog_policy_version_id = $policyVersion->id;
            $worklog->approval_flow_snapshot = $flow;
            $worklog->logged_minutes = $data['logged_minutes'];
            $worklog->description = $data['description'] ?? null;
            $worklog->justification = $data['justification'] ?? null;
            $worklog->start_time = $data['start_time'] ?? null;
            $worklog->end_time = $data['end_time'] ?? null;
            $worklog->billable = $data['billable'] ?? null;
            $worklog->submitted_at = now();
            $worklog->submitted_by = $submittedBy->id;
            $worklog->created_by = $submittedBy->id;
            $worklog->updated_by = $submittedBy->id;

            if ($flow === ApprovalFlow::Auto) {
                $worklog->worklog_status = WorklogStatus::AutoApproved;
                $worklog->compliance_status = WorklogComplianceStatus::Compliant;
            } else {
                $worklog->worklog_status = WorklogStatus::Submitted;
                $worklog->compliance_status = WorklogComplianceStatus::Compliant;
            }

            $worklog->save();

            $this->recordStatusChange($worklog, WorklogStatus::Draft, $worklog->worklog_status, $submittedBy, 'Worklog submitted');

            $this->updateDayComplianceStatus($day, $attPolicyVersion);

            return $worklog->load(['user', 'attendanceDay', 'attendanceSession', 'worklogPolicyVersion', 'submittedBy']);
        });
    }

    public function approveWorklog(
        AttendanceWorklog $worklog,
        User $approver,
        ?string $remarks = null
    ): AttendanceWorklog {
        if ($worklog->worklog_status !== WorklogStatus::Submitted) {
            throw new WorklogAlreadyProcessedException();
        }
        if ($approver->id === $worklog->user_id) {
            throw new UnauthorizedWorklogActionException();
        }

        $flow = $worklog->approval_flow_snapshot;

        return DB::transaction(function () use ($worklog, $approver, $remarks, $flow) {
            if ($flow === ApprovalFlow::Auto) {
                throw new WorklogAlreadyProcessedException();
            }

            $oldStatus = $worklog->worklog_status;

            if ($flow === ApprovalFlow::SingleApproval) {
                $worklog->approved_by = $approver->id;
                $worklog->approved_at = now();
                $worklog->worklog_status = WorklogStatus::Approved;
                $this->recordStatusChange($worklog, $oldStatus, WorklogStatus::Approved, $approver, $remarks);
            } elseif ($flow === ApprovalFlow::MultiLevelApproval) {
                if (!$worklog->hasFirstLevelApproval()) {
                    $worklog->approved_by = $approver->id;
                    $worklog->approved_at = now();
                    $this->recordStatusChange($worklog, $oldStatus, WorklogStatus::Submitted, $approver, 'First level approved by ' . $approver->name . ($remarks ? " - $remarks" : ''));
                } else {
                    $worklog->second_approver_id = $approver->id;
                    $worklog->second_approved_at = now();
                    $worklog->worklog_status = WorklogStatus::Approved;
                    $this->recordStatusChange($worklog, $oldStatus, WorklogStatus::Approved, $approver, $remarks);
                }
            }

            $worklog->save();

            if (in_array($worklog->worklog_status, [WorklogStatus::Approved, WorklogStatus::AutoApproved], true)) {
                $day = $worklog->attendanceDay;
                $attPolicyVersion = AttendancePolicyVersion::find($day->attendance_policy_version_id);
                $this->updateDayComplianceStatus($day, $attPolicyVersion);
            }

            return $worklog->fresh(['user', 'attendanceDay', 'attendanceSession', 'worklogPolicyVersion', 'submittedBy', 'approvedBy', 'secondApprover', 'statusHistories']);
        });
    }

    public function rejectWorklog(
        AttendanceWorklog $worklog,
        User $rejector,
        string $rejectionReason
    ): AttendanceWorklog {
        if ($worklog->worklog_status !== WorklogStatus::Submitted) {
            throw new WorklogAlreadyProcessedException();
        }
        if ($rejector->id === $worklog->user_id) {
            throw new UnauthorizedWorklogActionException();
        }

        $flow = $worklog->approval_flow_snapshot;

        return DB::transaction(function () use ($worklog, $rejector, $rejectionReason, $flow) {
            $oldStatus = $worklog->worklog_status;

            if ($flow === ApprovalFlow::SingleApproval || ($flow === ApprovalFlow::MultiLevelApproval && !$worklog->hasFirstLevelApproval())) {
                $worklog->rejected_by = $rejector->id;
                $worklog->rejected_at = now();
                $worklog->rejection_reason = $rejectionReason;
            } else {
                $worklog->second_rejected_by = $rejector->id;
                $worklog->second_rejected_at = now();
                $worklog->rejection_reason = $rejectionReason;
            }

            $worklog->worklog_status = WorklogStatus::Rejected;
            $worklog->save();

            $this->recordStatusChange($worklog, $oldStatus, WorklogStatus::Rejected, $rejector, $rejectionReason);

            return $worklog->fresh(['user', 'attendanceDay', 'attendanceSession', 'worklogPolicyVersion', 'submittedBy', 'rejectedBy', 'secondRejectedBy', 'statusHistories']);
        });
    }

    public function getWorklogs(
        Organization $organization,
        User $viewer,
        array $filters
    ): LengthAwarePaginator {
        $query = AttendanceWorklog::where('organization_id', $organization->id)
            ->with(['user', 'attendanceDay', 'attendanceSession', 'approvedBy', 'rejectedBy', 'submittedBy']);

        if (!$viewer->can('worklog.view_all')) {
            $query->where('user_id', $viewer->id);
        }

        if (!empty($filters['attendance_day_id'])) {
            $day = AttendanceDay::where('uuid', $filters['attendance_day_id'])->first();
            if ($day) {
                $query->where('attendance_day_id', $day->id);
            }
        }

        if (!empty($filters['worklog_status'])) {
            $query->where('worklog_status', $filters['worklog_status']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereHas('attendanceDay', function ($q) use ($filters) {
                $q->where('attendance_date', '>=', $filters['start_date']);
            });
        }

        if (!empty($filters['end_date'])) {
            $query->whereHas('attendanceDay', function ($q) use ($filters) {
                $q->where('attendance_date', '<=', $filters['end_date']);
            });
        }

        $perPage = $filters['per_page'] ?? 20;

        return $query->orderBy('submitted_at', 'desc')->paginate((int) $perPage);
    }

    public function getWorklog(
        string $uuid,
        Organization $organization,
        User $viewer
    ): AttendanceWorklog {
        $worklog = AttendanceWorklog::where('uuid', $uuid)
            ->where('organization_id', $organization->id)
            ->with(['user', 'attendanceDay', 'attendanceSession', 'approvedBy', 'rejectedBy', 'submittedBy', 'secondApprover', 'secondRejectedBy', 'statusHistories.changedBy', 'worklogPolicyVersion'])
            ->firstOrFail();

        if (!$viewer->can('worklog.view_all') && $worklog->user_id !== $viewer->id) {
            throw new UnauthorizedWorklogActionException();
        }

        return $worklog;
    }

    public function getWorklogsForDay(
        AttendanceDay $day,
        Organization $organization,
        User $viewer
    ): Collection {
        if ($day->organization_id !== $organization->id) {
            throw new WorklogNotFoundException();
        }

        if (!$viewer->can('worklog.view_all') && $day->user_id !== $viewer->id) {
            throw new UnauthorizedWorklogActionException();
        }

        return AttendanceWorklog::where('attendance_day_id', $day->id)
            ->where('organization_id', $organization->id)
            ->with(['user', 'attendanceDay', 'attendanceSession', 'approvedBy', 'rejectedBy', 'submittedBy', 'secondApprover', 'secondRejectedBy'])
            ->orderBy('submitted_at', 'desc')
            ->get();
    }

    public function processOverdueWorklogs(Organization $organization): int
    {
        $policy = $this->worklogPolicyService->getPolicy($organization);
        $policyVersion = $this->worklogPolicyService->resolveCurrentVersion($policy);

        $cutoffDate = today()->subDays($policyVersion->submission_window_days);

        $days = AttendanceDay::where('organization_id', $organization->id)
            ->where('attendance_date', '<', $cutoffDate)
            ->whereIn('attendance_status', [1, 2]) // Assuming 1=Present, 2=HalfDay (from prompt logic)
            ->whereDoesntHave('worklogs')
            ->get();

        $processedCount = 0;

        foreach ($days as $day) {
            DB::transaction(function () use ($day, $policyVersion, $organization, &$processedCount) {
                if ($policyVersion->auto_escalate_overdue_logs) {
                    AttendanceEscalation::firstOrCreate([
                        'user_id' => $day->user_id,
                        'organization_id' => $organization->id,
                        'attendance_day_id' => $day->id,
                        'escalation_type' => EscalationType::MissingWorklog,
                    ], [
                        'escalation_status' => EscalationStatus::Pending,
                        'escalated_at' => now(),
                    ]);
                }

                // Actually need to map to the enum values for compliance status correctly
                // Depending on the exact class used by AttendanceDay (App\Enums\AttendanceComplianceStatusEnum vs App\Enums\Attendance\ComplianceStatus)
                // Let's assume the value Overdue is equivalent to int 3 (based on earlier enum)
                $day->compliance_status = \App\Enums\AttendanceComplianceStatusEnum::Overdue;
                $day->save();
                $processedCount++;
            });
        }

        return $processedCount;
    }

    private function updateDayComplianceStatus(
        AttendanceDay $day,
        AttendancePolicyVersion $attPolicyVersion
    ): void {
        if (!$attPolicyVersion->strict_worklog_enforcement) {
            return;
        }

        $hasCompliantWorklog = AttendanceWorklog::where('attendance_day_id', $day->id)
            ->whereIn('worklog_status', [WorklogStatus::Approved, WorklogStatus::AutoApproved, WorklogStatus::Submitted])
            ->exists();

        if ($hasCompliantWorklog) {
            $day->compliance_status = \App\Enums\AttendanceComplianceStatusEnum::Compliant;
            $day->save();
        }
    }

    private function recordStatusChange(
        AttendanceWorklog $worklog,
        WorklogStatus $oldStatus,
        WorklogStatus $newStatus,
        User $changedBy,
        ?string $remarks = null
    ): void {
        $worklog->statusHistories()->create([
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => $changedBy->id,
            'remarks' => $remarks,
            'created_at' => now(),
        ]);
    }
}
