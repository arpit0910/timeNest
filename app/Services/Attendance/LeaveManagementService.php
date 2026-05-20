<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\LeaveStatusEnum;
use App\Enums\LeaveTypeEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Attendance\EmployeeLeave;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveManagementService
{
    /**
     * Create a new leave request after validation.
     */
    public function applyForLeave(User $user, Corporation $corporation, array $data): EmployeeLeave
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
        
        $leaveType = LeaveTypeEnum::from((int) $data['leave_type']);
        if ($leaveType === LeaveTypeEnum::HalfDay) {
            $totalDays = 0.5;
        } else {
            $totalDays = $start->diffInDays($end) + 1.0;
        }

        return EmployeeLeave::create([
            'corporation_id' => $corporation->id,
            'user_id' => $user->id,
            'leave_type' => $leaveType->value,
            'leave_status' => LeaveStatusEnum::Pending->value,
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
                LeaveStatusEnum::Pending->value,
                LeaveStatusEnum::Approved->value,
                LeaveStatusEnum::AutoApproved->value
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
            ->where('leave_type', LeaveTypeEnum::WorkFromHome->value)
            ->whereIn('leave_status', [LeaveStatusEnum::Approved->value, LeaveStatusEnum::AutoApproved->value])
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
            ->where('leave_type', LeaveTypeEnum::ExtraWorkingDay->value)
            ->whereIn('leave_status', [LeaveStatusEnum::Approved->value, LeaveStatusEnum::AutoApproved->value])
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
                LeaveTypeEnum::WorkFromHome->value,
                LeaveTypeEnum::ExtraWorkingDay->value
            ])
            ->whereIn('leave_status', [LeaveStatusEnum::Approved->value, LeaveStatusEnum::AutoApproved->value])
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->exists();
    }}
