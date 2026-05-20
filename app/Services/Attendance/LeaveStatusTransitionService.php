<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\LeaveStatusEnum;
use App\Enums\SystemPermission;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Attendance\EmployeeLeave;
use App\Models\Attendance\LeaveStatusHistory;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;

class LeaveStatusTransitionService
{
    /**
     * Define the valid transitions from each state.
     * key: current status (int)
     * value: array of allowed target statuses (int)
     */
    private const ALLOWED_TRANSITIONS = [
        LeaveStatusEnum::Draft->value => [
            LeaveStatusEnum::Pending->value,
            LeaveStatusEnum::Cancelled->value,
        ],
        LeaveStatusEnum::Pending->value => [
            LeaveStatusEnum::ManagerApproved->value,
            LeaveStatusEnum::HRApproved->value,
            LeaveStatusEnum::Approved->value,
            LeaveStatusEnum::Rejected->value,
            LeaveStatusEnum::Cancelled->value,
            LeaveStatusEnum::OnHold->value,
            LeaveStatusEnum::RevisionRequested->value,
            LeaveStatusEnum::ComplianceReview->value,
            LeaveStatusEnum::PartiallyApproved->value,
            LeaveStatusEnum::Escalated->value,
        ],
        LeaveStatusEnum::ManagerApproved->value => [
            LeaveStatusEnum::HRApproved->value,
            LeaveStatusEnum::Approved->value,
            LeaveStatusEnum::Rejected->value,
            LeaveStatusEnum::Cancelled->value,
            LeaveStatusEnum::Escalated->value,
            LeaveStatusEnum::RevisionRequested->value,
        ],
        LeaveStatusEnum::HRApproved->value => [
            LeaveStatusEnum::Approved->value,
            LeaveStatusEnum::Rejected->value,
            LeaveStatusEnum::Cancelled->value,
            LeaveStatusEnum::RevisionRequested->value,
        ],
        LeaveStatusEnum::OnHold->value => [
            LeaveStatusEnum::Pending->value,
            LeaveStatusEnum::Approved->value,
            LeaveStatusEnum::Rejected->value,
            LeaveStatusEnum::Cancelled->value,
        ],
        LeaveStatusEnum::RevisionRequested->value => [
            LeaveStatusEnum::Draft->value,
            LeaveStatusEnum::Pending->value,
            LeaveStatusEnum::Cancelled->value,
        ],
        LeaveStatusEnum::ComplianceReview->value => [
            LeaveStatusEnum::Approved->value,
            LeaveStatusEnum::Rejected->value,
            LeaveStatusEnum::Cancelled->value,
            LeaveStatusEnum::OnHold->value,
        ],
        LeaveStatusEnum::PartiallyApproved->value => [
            LeaveStatusEnum::Approved->value,
            LeaveStatusEnum::Rejected->value,
            LeaveStatusEnum::Cancelled->value,
        ],
        LeaveStatusEnum::Escalated->value => [
            LeaveStatusEnum::Approved->value,
            LeaveStatusEnum::Rejected->value,
            LeaveStatusEnum::Cancelled->value,
            LeaveStatusEnum::OnHold->value,
        ],
    ];

    /**
     * Transition the status of an employee leave.
     */
    public function transition(EmployeeLeave $leave, LeaveStatusEnum $newStatus, User $actor, ?string $remarks = null, ?array $metadata = null): EmployeeLeave
    {
        $oldStatus = $leave->leave_status;

        // 1. Guard identical transitions
        if ($oldStatus === $newStatus) {
            return $leave;
        }

        // 2. Validate Allowed Transitions
        $allowed = self::ALLOWED_TRANSITIONS[$oldStatus->value] ?? [];
        if (! in_array($newStatus->value, $allowed, true)) {
            throw new BusinessRuleViolationException(
                sprintf('Transition from %s to %s is not allowed.', $oldStatus->label(), $newStatus->label()),
                'INVALID_STATUS_TRANSITION'
            );
        }

        // 3. Validate Actor Permissions
        $this->validatePermissions($leave, $newStatus, $actor);

        // 4. Update the Leave status and log to history in a transaction
        return DB::transaction(function () use ($leave, $oldStatus, $newStatus, $actor, $remarks, $metadata) {
            
            // Build updates array
            $updates = [
                'leave_status' => $newStatus->value,
            ];

            // Maintain legacy approved_by/rejected_by fields for compatibility
            if ($newStatus === LeaveStatusEnum::Approved) {
                $updates['approved_by'] = $actor->id;
                $updates['approved_at'] = now();
            } elseif ($newStatus === LeaveStatusEnum::Rejected) {
                $updates['rejected_by'] = $actor->id;
                $updates['rejected_at'] = now();
                $updates['cancellation_reason'] = $remarks;
            } elseif ($newStatus === LeaveStatusEnum::Cancelled) {
                $updates['cancellation_reason'] = $remarks;
            }

            $leave->update($updates);

            // Log status history
            LeaveStatusHistory::create([
                'employee_leave_id' => $leave->id,
                'old_status' => $oldStatus->value,
                'new_status' => $newStatus->value,
                'changed_by' => $actor->id,
                'remarks' => $remarks,
                'metadata' => $metadata,
            ]);

            return $leave;
        });
    }

    /**
     * Check if the actor has permission to trigger the state transition.
     */
    private function validatePermissions(EmployeeLeave $leave, LeaveStatusEnum $newStatus, User $actor): void
    {
        // 1. Employee Self-cancellation Check
        if ($newStatus === LeaveStatusEnum::Cancelled) {
            // Employee can cancel their own leave if it is not already approved/processed (or they can do it anytime if it's pending)
            if ($leave->user_id === $actor->id) {
                return;
            }
        }

        // 2. Draft/Pending submittals by Employee
        if ($leave->user_id === $actor->id && in_array($newStatus, [LeaveStatusEnum::Draft, LeaveStatusEnum::Pending], true)) {
            return;
        }

        // 3. Managerial/HR transitions require permission check scoped to tenant corporation
        setPermissionsTeamId($leave->corporation_id);
        $hasPermission = $actor->hasPermissionTo(SystemPermission::LeavesApprove->value);
        setPermissionsTeamId(null);

        if (! $hasPermission) {
            throw new BusinessRuleViolationException(
                'You are not authorized to transition this leave request to the target status.',
                'UNAUTHORIZED_TRANSITION'
            );
        }
    }
}
