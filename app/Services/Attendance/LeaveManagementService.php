<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\Leave\LeaveStatus;
use App\Enums\Leave\LeaveType;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Leave\EmployeeLeave;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveManagementService
{
    /**
     * Create a new leave request after validation.
     */
    public function applyForLeave(User $user, Organization $organization, array $data): EmployeeLeave
    {
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        if (Carbon::parse($startDate)->gt(Carbon::parse($endDate))) {
            throw new BusinessRuleViolationException('Start date cannot be after end date.', 'INVALID_LEAVE_DATES');
        }

        // Overlap detection
        $this->detectOverlap($user->id, $startDate, $endDate);

        // Calculate total days
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        $leaveType = LeaveType::from((int) $data['leave_type']);
        if ($leaveType === LeaveType::HALF_DAY) {
            $totalDays = 0.5;
        } else {
            $totalDays = $start->diffInDays($end) + 1.0;
        }

        return EmployeeLeave::create([
            'organization_id' => $organization->id,
            'user_id' => $user->id,
            'leave_type' => $leaveType->value,
            'leave_status' => LeaveStatus::PENDING->value,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $totalDays,
            'reason' => $data['reason'],
            'attachment_path' => $data['attachment_path'] ?? null,
            'metadata' => $data['metadata'] ?? null,
        ]);
    }

    /**
     * Check if the user has overlapping leaves.
     */
    public function detectOverlap(int $userId, string $startDate, string $endDate, ?int $ignoreLeaveId = null): void
    {
        $query = EmployeeLeave::where('user_id', $userId)
            ->whereIn('leave_status', [
                LeaveStatus::PENDING->value,
                LeaveStatus::APPROVED->value,
                LeaveStatus::AUTO_APPROVED->value
            ])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where(function ($sub) use ($startDate, $endDate) {
                    $sub->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                });
            });

        if ($ignoreLeaveId) {
            $query->where('id', '!=', $ignoreLeaveId);
        }

        if ($query->exists()) {
            throw new BusinessRuleViolationException(
                'You have an overlapping leave request or approved leave for this duration.',
                'LEAVE_OVERLAP'
            );
        }
    }

    /**
     * Check if the user has an approved WFH leave for the given date.
     */
    public function hasApprovedWFH(int $userId, string $date): bool
    {
        return EmployeeLeave::where('user_id', $userId)
            ->where('leave_type', LeaveType::WORK_FROM_HOME->value)
            ->whereIn('leave_status', [LeaveStatus::APPROVED->value, LeaveStatus::AUTO_APPROVED->value])
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->exists();
    }

    /**
     * Check if the user has an approved EWD leave for the given date.
     */
    public function hasApprovedEWD(int $userId, string $date): bool
    {
        return EmployeeLeave::where('user_id', $userId)
            ->where('leave_type', LeaveType::EXTRA_WORKING_DAY->value)
            // Need to change the status comparison as can't only allow fully apprved leaves
            ->whereIn('leave_status', [LeaveStatus::APPROVED->value, LeaveStatus::AUTO_APPROVED->value])
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->exists();
    }

    /**
     * Check if the user has any approved leave of any kind for the given date.
     */
    public function hasApprovedLeave(int $userId, string $date): bool
    {
        // Don't treat WFH/EWD as standard leaves that prevent clocking in
        return EmployeeLeave::where('user_id', $userId)
            ->whereNotIn('leave_type', [
                LeaveType::WORK_FROM_HOME->value,
                LeaveType::EXTRA_WORKING_DAY->value
            ])
            ->whereIn('leave_status', [LeaveStatus::APPROVED->value, LeaveStatus::AUTO_APPROVED->value])
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->exists();
    }}
