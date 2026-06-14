<?php

declare(strict_types=1);

namespace App\Services\Leave;

use App\Enums\Leave\ApprovalFlow;
use App\Enums\Leave\LeaveStatus;
use App\Enums\Leave\LeaveType as LeaveTypeEnum;
use App\Exceptions\Leave\InsufficientLeaveBalanceException;
use App\Exceptions\Leave\LeaveAdvanceNoticeException;
use App\Exceptions\Leave\LeaveCancellationNotAllowedException;
use App\Exceptions\Leave\LeaveDocumentRequiredException;
use App\Exceptions\Leave\LeaveOverlapException;
use App\Exceptions\Leave\LeaveRequestAlreadyProcessedException;
use App\Exceptions\Leave\LeaveRequestNotFoundException;
use App\Exceptions\Leave\LeaveTypeNotActiveException;
use App\Exceptions\Leave\UnauthorizedLeaveActionException;
use App\Models\Auth\User;
use App\Models\Leave\EmployeeLeave;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveStatusHistory;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use App\Models\Attendance\OrganizationHoliday;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LeaveRequestService
{
    public function __construct(
        private LeavePolicyService $leavePolicyService,
        private LeaveTypeService $leaveTypeService
    ) {
    }

    public function submitLeave(Organization $organization, User $user, array $data): EmployeeLeave
    {
        $leaveType = LeaveType::where('organization_id', $organization->id)
            ->where('uuid', $data['leave_type_id'])
            ->firstOrFail();

        if (!$leaveType->is_active) {
            throw new LeaveTypeNotActiveException();
        }

        $policy = $this->leavePolicyService->getPolicy($organization);
        $policyVersion = $this->leavePolicyService->resolveCurrentVersion($policy);

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);

        $totalDays = $this->calculateLeaveDays($start, $end, $policyVersion, $organization);

        if ($data['is_half_day'] ?? false) {
            $totalDays = 0.5;
            if ($start->toDateString() !== $end->toDateString()) {
                throw ValidationException::withMessages(['end_date' => 'Half day leave must be on a single date.']);
            }
        }

        $this->validateLeaveSubmission(
            null,
            $leaveType,
            $policyVersion,
            $start,
            $end,
            $totalDays,
            $data,
            $user,
            $organization
        );

        $year = (int) $start->format('Y');
        $balance = $this->findOrCreateBalance($organization, $user, $leaveType, $year);

        if (!$policy->negative_balance_allowed && ($balance->remaining_days - $totalDays) < 0) {
            throw new InsufficientLeaveBalanceException();
        }

        return DB::transaction(function () use ($organization, $user, $leaveType, $policyVersion, $start, $end, $totalDays, $data, $balance) {
            $flow = $policyVersion->approval_flow;

            $leaveStatus = match ($flow) {
                ApprovalFlow::Auto => LeaveStatus::AutoApproved,
                ApprovalFlow::SingleApproval, ApprovalFlow::MultiLevelApproval => LeaveStatus::Pending,
            };

            $leave = new EmployeeLeave([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'leave_type' => LeaveTypeEnum::from((int) $leaveType->code),
                'leave_type_id' => $leaveType->id,
                'leave_policy_version_id' => $policyVersion->id,
                'approval_flow_snapshot' => $flow->value,
                'leave_status' => $leaveStatus->value,
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
                'total_days' => $totalDays,
                'is_carry_forward' => false,
                'reason' => $data['reason'],
                'attachment_path' => $data['attachment_path'] ?? null,
                'auto_approved_at' => $flow === ApprovalFlow::Auto ? now() : null,
            ]);

            if ($flow === ApprovalFlow::Auto) {
                $balance->used_days += $totalDays;
                $balance->remaining_days -= $totalDays;
            } else {
                $balance->pending_days += $totalDays;
                $balance->remaining_days -= $totalDays;
            }

            $leave->save();
            $balance->save();

            $this->recordStatusChange($leave, LeaveStatus::Draft, $leaveStatus, $user, 'Initial submission');

            $leave->load(['leaveType', 'policyVersion', 'statusHistories']);
            return $leave;
        });
    }

    public function approveLeave(EmployeeLeave $leave, User $approver, ?string $remarks = null): EmployeeLeave
    {
        if ($leave->leave_status !== LeaveStatus::Pending) {
            throw new LeaveRequestAlreadyProcessedException();
        }

        if ($approver->id === $leave->user_id) {
            throw new UnauthorizedLeaveActionException();
        }

        $flow = $leave->approval_flow_snapshot;

        if ($flow === ApprovalFlow::Auto) {
            throw new LeaveRequestAlreadyProcessedException();
        }

        return DB::transaction(function () use ($leave, $approver, $remarks, $flow) {
            $balance = LeaveBalance::where('organization_id', $leave->organization_id)
                ->where('user_id', $leave->user_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->where('year', (int) Carbon::parse($leave->start_date)->format('Y'))
                ->firstOrFail();

            $oldStatus = $leave->leave_status;

            if ($flow === ApprovalFlow::SingleApproval) {
                $leave->approved_by = $approver->id;
                $leave->approved_at = now();
                $leave->leave_status = LeaveStatus::Approved->value;
                
                $balance->used_days += $leave->total_days;
                $balance->pending_days -= $leave->total_days;
            } else { // MultiLevelApproval
                if (!$leave->hasFirstLevelApproval()) {
                    $leave->approved_by = $approver->id;
                    $leave->approved_at = now();
                } else {
                    $leave->second_approver_id = $approver->id;
                    $leave->second_approved_at = now();
                    $leave->leave_status = LeaveStatus::Approved->value;

                    $balance->used_days += $leave->total_days;
                    $balance->pending_days -= $leave->total_days;
                }
            }

            $leave->save();
            $balance->save();

            if ($leave->leave_status !== $oldStatus) {
                $this->recordStatusChange($leave, $oldStatus, LeaveStatus::Approved, $approver, $remarks);
            }

            $leave->load(['leaveType', 'policyVersion', 'statusHistories']);
            return $leave;
        });
    }

    public function rejectLeave(EmployeeLeave $leave, User $rejector, string $rejectionReason): EmployeeLeave
    {
        if ($leave->leave_status !== LeaveStatus::Pending) {
            throw new LeaveRequestAlreadyProcessedException();
        }

        if ($rejector->id === $leave->user_id) {
            throw new UnauthorizedLeaveActionException();
        }

        return DB::transaction(function () use ($leave, $rejector, $rejectionReason) {
            $balance = LeaveBalance::where('organization_id', $leave->organization_id)
                ->where('user_id', $leave->user_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->where('year', (int) Carbon::parse($leave->start_date)->format('Y'))
                ->firstOrFail();

            $flow = $leave->approval_flow_snapshot;
            $oldStatus = $leave->leave_status;

            if ($flow === ApprovalFlow::SingleApproval || !$leave->hasFirstLevelApproval()) {
                $leave->rejected_by = $rejector->id;
                $leave->rejected_at = now();
            } else {
                $leave->rejected_by = $rejector->id;
                $leave->rejected_at = now();
                $leave->cancellation_reason = $rejectionReason;
            }
            $leave->leave_status = LeaveStatus::Rejected->value;

            $leave->cancellation_reason = $rejectionReason;

            $balance->pending_days -= $leave->total_days;
            $balance->remaining_days += $leave->total_days;

            $leave->save();
            $balance->save();

            $this->recordStatusChange($leave, $oldStatus, LeaveStatus::Rejected, $rejector, $rejectionReason);

            $leave->load(['leaveType', 'policyVersion', 'statusHistories']);
            return $leave;
        });
    }

    public function cancelLeave(EmployeeLeave $leave, User $canceller, string $reason): EmployeeLeave
    {
        if ($leave->user_id !== $canceller->id) {
            throw new UnauthorizedLeaveActionException();
        }

        $policy = $this->leavePolicyService->getPolicy($leave->organization);

        if (!$policy->allow_leave_cancellation) {
            throw new LeaveCancellationNotAllowedException('Leave cancellation is not permitted by your organization policy.');
        }

        if (!in_array($leave->leave_status, [LeaveStatus::Pending, LeaveStatus::Approved, LeaveStatus::AutoApproved], true)) {
            throw new LeaveRequestAlreadyProcessedException();
        }

        if (in_array($leave->leave_status, [LeaveStatus::Approved, LeaveStatus::AutoApproved], true)) {
            $cancelBeforeHours = $policy->cancellation_before_hours ?? 0;
            $startTime = Carbon::parse($leave->start_date)->startOfDay();
            if (now()->diffInHours($startTime, false) < $cancelBeforeHours) {
                throw new LeaveCancellationNotAllowedException("Cancellation must be made at least {$cancelBeforeHours} hours before leave starts.");
            }
        }

        return DB::transaction(function () use ($leave, $canceller, $reason) {
            $balance = LeaveBalance::where('organization_id', $leave->organization_id)
                ->where('user_id', $leave->user_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->where('year', (int) Carbon::parse($leave->start_date)->format('Y'))
                ->firstOrFail();

            $oldStatus = $leave->leave_status;

            $leave->leave_status = LeaveStatus::Cancelled->value;
            $leave->cancellation_reason = $reason;

            if ($oldStatus === LeaveStatus::Pending) {
                $balance->pending_days -= $leave->total_days;
                $balance->remaining_days += $leave->total_days;
            } else {
                $balance->used_days -= $leave->total_days;
                $balance->remaining_days += $leave->total_days;
            }

            $leave->save();
            $balance->save();

            $this->recordStatusChange($leave, $oldStatus, LeaveStatus::Cancelled, $canceller, $reason);

            $leave->load(['leaveType', 'policyVersion', 'statusHistories']);
            return $leave;
        });
    }

    public function getLeaveRequests(Organization $organization, User $viewer, array $filters): LengthAwarePaginator
    {
        $query = EmployeeLeave::with(['user', 'leaveType', 'approvedBy', 'rejectedBy'])
            ->where('organization_id', $organization->id);

        if (!$viewer->can('leave.request.view_all')) {
            $query->where('user_id', $viewer->id);
        } else if (isset($filters['user_id'])) {
            $user = User::where('uuid', $filters['user_id'])->first();
            if ($user) {
                $query->where('user_id', $user->id);
            }
        }

        if (isset($filters['start_date'])) {
            $query->where('start_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->where('end_date', '<=', $filters['end_date']);
        }

        if (isset($filters['leave_status'])) {
            $query->where('leave_status', $filters['leave_status']);
        }

        if (isset($filters['leave_type_id'])) {
            $leaveType = LeaveType::where('uuid', $filters['leave_type_id'])->first();
            if ($leaveType) {
                $query->where('leave_type_id', $leaveType->id);
            }
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    public function getLeaveRequest(string $uuid, Organization $organization, User $viewer): EmployeeLeave
    {
        $leave = EmployeeLeave::with(['user', 'leaveType', 'approvedBy', 'rejectedBy', 'statusHistories'])
            ->where('uuid', $uuid)
            ->where('organization_id', $organization->id)
            ->firstOrFail();

        if ($leave->user_id !== $viewer->id && !$viewer->can('leave.request.view_all')) {
            throw new UnauthorizedLeaveActionException();
        }

        return $leave;
    }

    public function getLeaveBalance(Organization $organization, User $user, int $year): Collection
    {
        return LeaveBalance::with(['leaveType'])
            ->where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->where('year', $year)
            ->get();
    }

    public function processAutoApprovals(Organization $organization): int
    {
        $policy = $this->leavePolicyService->getPolicy($organization);
        
        if ($policy->auto_approve_after_hours === null) {
            return 0;
        }

        $cutoff = now()->subHours($policy->auto_approve_after_hours);

        $leaves = EmployeeLeave::where('organization_id', $organization->id)
            ->where('leave_status', LeaveStatus::Pending->value)
            ->where('approval_flow_snapshot', ApprovalFlow::SingleApproval->value)
            ->where('created_at', '<=', $cutoff)
            ->get();

        $count = 0;
        $systemUser = User::first(); // Assuming system user or another fallback logic

        foreach ($leaves as $leave) {
            if ($systemUser) {
                $this->approveLeave($leave, $systemUser, 'Auto-approved by system');
                $count++;
            } else {
                DB::transaction(function () use ($leave) {
                    $leave->leave_status = LeaveStatus::AutoApproved->value;
                    $leave->auto_approved_at = now();

                    $balance = LeaveBalance::where('organization_id', $leave->organization_id)
                        ->where('user_id', $leave->user_id)
                        ->where('leave_type_id', $leave->leave_type_id)
                        ->where('year', (int) Carbon::parse($leave->start_date)->format('Y'))
                        ->first();
                    
                    if ($balance) {
                        $balance->used_days += $leave->total_days;
                        $balance->pending_days -= $leave->total_days;
                        $balance->save();
                    }

                    $leave->save();
                });
                $count++;
            }
        }

        return $count;
    }

    private function calculateLeaveDays(
        Carbon $start,
        Carbon $end,
        LeavePolicyVersion $policyVersion,
        Organization $organization
    ): float {
        $totalDays = 0.0;
        $current = $start->copy();

        $weekendDays = $policyVersion->weekend_days ?? [];
        $allowWeekends = $policyVersion->allow_leave_on_weekends ?? false;
        $allowHolidays = $policyVersion->allow_leave_on_holidays ?? false;

        $holidays = [];
        if (!$allowHolidays) {
            $holidays = OrganizationHoliday::where('organization_id', $organization->id)
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('holiday_date', [$start->toDateString(), $end->toDateString()])
                      ->orWhere('is_recurring', true);
                })
                ->get();
        }

        while ($current->lte($end)) {
            $isWeekend = in_array(strtolower($current->englishDayOfWeek), array_map('strtolower', $weekendDays));
            
            $isHoliday = false;
            if (!$allowHolidays) {
                foreach ($holidays as $holiday) {
                    if ($holiday->is_recurring) {
                        if (Carbon::parse($holiday->holiday_date)->format('m-d') === $current->format('m-d')) {
                            $isHoliday = true;
                            break;
                        }
                    } else if ($holiday->holiday_date === $current->toDateString()) {
                        $isHoliday = true;
                        break;
                    }
                }
            }

            if ((!$isWeekend || $allowWeekends) && (!$isHoliday)) {
                $totalDays += 1.0;
            }

            $current->addDay();
        }

        return $totalDays;
    }

    private function validateLeaveSubmission(
        EmployeeLeave|null $leave,
        LeaveType $leaveType,
        LeavePolicyVersion $policyVersion,
        Carbon $start,
        Carbon $end,
        float $totalDays,
        array $data,
        User $user,
        Organization $organization
    ): void {
        if ($data['is_half_day'] ?? false) {
            if (!$policyVersion->allow_half_day_leaves) {
                throw ValidationException::withMessages(['is_half_day' => 'Half day leaves are not permitted by policy.']);
            }
            if (!$leaveType->allow_half_day) {
                throw ValidationException::withMessages(['is_half_day' => 'Half day leaves are not permitted for this leave type.']);
            }
        }

        $earliestAllowedDate = today()->addDays($policyVersion->advance_notice_required_days);
        if ($start->lt($earliestAllowedDate)) {
            throw new LeaveAdvanceNoticeException("At least {$policyVersion->advance_notice_required_days} days of advance notice is required.");
        }

        $latestAllowedDate = today()->addDays($policyVersion->max_advance_application_days);
        if ($start->gt($latestAllowedDate)) {
            throw ValidationException::withMessages(['start_date' => "Cannot apply for leave more than {$policyVersion->max_advance_application_days} days in advance."]);
        }

        if ($leaveType->max_per_request_days !== null && $totalDays > $leaveType->max_per_request_days) {
            throw ValidationException::withMessages(['end_date' => "Cannot exceed maximum of {$leaveType->max_per_request_days} days per request for this leave type."]);
        }

        if ($leaveType->min_per_request_days !== null && $totalDays < $leaveType->min_per_request_days) {
            throw ValidationException::withMessages(['end_date' => "Must take at least {$leaveType->min_per_request_days} days per request for this leave type."]);
        }

        if ($leaveType->requires_document || ($policyVersion->document_required_after_days !== null && $totalDays > $policyVersion->document_required_after_days)) {
            if (empty($data['attachment_path'])) {
                throw new LeaveDocumentRequiredException();
            }
        }

        $overlapQuery = EmployeeLeave::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->whereNotIn('leave_status', [LeaveStatus::Rejected->value, LeaveStatus::Cancelled->value])
            ->where(function ($q) use ($start, $end) {
                $q->where('start_date', '<=', $end->toDateString())
                  ->where('end_date', '>=', $start->toDateString());
            });

        if ($overlapQuery->exists()) {
            throw new LeaveOverlapException();
        }
    }

    private function recordStatusChange(
        EmployeeLeave $leave,
        LeaveStatus $oldStatus,
        LeaveStatus $newStatus,
        User $changedBy,
        ?string $remarks = null
    ): void {
        LeaveStatusHistory::create([
            'employee_leave_id' => $leave->id,
            'old_status' => $oldStatus->value,
            'new_status' => $newStatus->value,
            'changed_by' => $changedBy->id,
            'remarks' => $remarks,
            'created_at' => now(),
        ]);
    }

    private function findOrCreateBalance(
        Organization $organization,
        User $user,
        LeaveType $leaveType,
        int $year
    ): LeaveBalance {
        $balance = LeaveBalance::where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->where('leave_type_id', $leaveType->id)
            ->where('year', $year)
            ->first();

        if (!$balance) {
            $balance = new LeaveBalance([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'leave_type_id' => $leaveType->id,
                'year' => $year,
                'allocated_days' => $leaveType->annual_allocation_days,
                'carry_forward_days' => 0,
                'used_days' => 0,
                'pending_days' => 0,
                'remaining_days' => $leaveType->annual_allocation_days,
            ]);
            $balance->save();
        }

        return $balance;
    }
}
