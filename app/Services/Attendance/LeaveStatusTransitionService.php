<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\Leave\LeaveStatus;
use App\Enums\SystemPermission;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Leave\EmployeeLeave;
use App\Models\Leave\LeaveStatusHistory;
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
        LeaveStatus::DRAFT->value => [
            LeaveStatus::PENDING->value,
            LeaveStatus::CANCELLED->value,
        ],
        LeaveStatus::PENDING->value => [
            LeaveStatus::APPROVED->value,
            LeaveStatus::REJECTED->value,
            LeaveStatus::CANCELLED->value,
            LeaveStatus::AUTO_APPROVED->value,
        ],
        LeaveStatus::APPROVED->value => [
            LeaveStatus::CANCELLED->value,
        ],
    ];

    /**
     * Transition the status of an employee leave.
     */
    public function transition(EmployeeLeave $leave, LeaveStatus $newStatus, User $actor, ?string $remarks = null, ?array $metadata = null): EmployeeLeave
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
            if ($newStatus === LeaveStatus::APPROVED) {
                $updates['approved_by'] = $actor->id;
                $updates['approved_at'] = now();
            } elseif ($newStatus === LeaveStatus::REJECTED) {
                $updates['rejected_by'] = $actor->id;
                $updates['rejected_at'] = now();
                $updates['cancellation_reason'] = $remarks;
            } elseif ($newStatus === LeaveStatus::CANCELLED) {
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
    private function validatePermissions(EmployeeLeave $leave, LeaveStatus $newStatus, User $actor): void
    {
        // 1. Employee Self-cancellation Check
        if ($newStatus === LeaveStatus::CANCELLED) {
            // Employee can cancel their own leave if it is not already approved/processed (or they can do it anytime if it's pending)
            if ($leave->user_id === $actor->id) {
                return;
            }
        }

        // 2. Draft/Pending submittals by Employee
        if ($leave->user_id === $actor->id && in_array($newStatus, [LeaveStatus::DRAFT, LeaveStatus::PENDING], true)) {
            return;
        }

        // 3. Managerial/HR transitions require permission check scoped to tenant organization
        setPermissionsTeamId($leave->organization_id);
        $hasPermission = $actor->hasPermissionTo(SystemPermission::LEAVES_APPROVE->value);
        setPermissionsTeamId(null);

        if (! $hasPermission) {
            throw new BusinessRuleViolationException(
                'You are not authorized to transition this leave request to the target status.',
                'UNAUTHORIZED_TRANSITION'
            );
        }
    }
}
