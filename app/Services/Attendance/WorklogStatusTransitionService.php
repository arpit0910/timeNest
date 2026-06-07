<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\WorkflowStatusEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class WorklogStatusTransitionService
{
    /**
     * Set of allowed transitions.
     */
    private const ALLOWED_TRANSITIONS = [
        WorkflowStatusEnum::Draft->value => [
            WorkflowStatusEnum::Submitted->value,
            WorkflowStatusEnum::Cancelled->value,
        ],
        WorkflowStatusEnum::Pending->value => [
            WorkflowStatusEnum::Submitted->value,
            WorkflowStatusEnum::Cancelled->value,
        ],
        WorkflowStatusEnum::Submitted->value => [
            WorkflowStatusEnum::Approved->value,
            WorkflowStatusEnum::Rejected->value,
            WorkflowStatusEnum::RevisionRequested->value,
            WorkflowStatusEnum::Escalated->value,
            WorkflowStatusEnum::Cancelled->value,
        ],
        WorkflowStatusEnum::Rejected->value => [
            WorkflowStatusEnum::Draft->value,
            WorkflowStatusEnum::Cancelled->value,
        ],
        WorkflowStatusEnum::RevisionRequested->value => [
            WorkflowStatusEnum::Draft->value,
            WorkflowStatusEnum::Cancelled->value,
        ],
        WorkflowStatusEnum::Escalated->value => [
            WorkflowStatusEnum::Approved->value,
            WorkflowStatusEnum::Rejected->value,
            WorkflowStatusEnum::RevisionRequested->value,
            WorkflowStatusEnum::Cancelled->value,
        ],
        WorkflowStatusEnum::Approved->value => [
            WorkflowStatusEnum::Locked->value,
            WorkflowStatusEnum::Cancelled->value,
        ],
    ];

    /**
     * Check if a transition is valid.
     */
    public function isValidTransition(WorkflowStatusEnum $from, WorkflowStatusEnum $to): bool
    {
        if (! isset(self::ALLOWED_TRANSITIONS[$from->value])) {
            return false;
        }

        return in_array($to->value, self::ALLOWED_TRANSITIONS[$from->value], true);
    }

    /**
     * Transition a worklog to a new status.
     *
     * @throws BusinessRuleViolationException
     * @throws UnauthorizedException
     */
    public function transition(
        AttendanceWorklog $worklog,
        WorkflowStatusEnum $targetStatus,
        User $actor,
        ?string $remarks = null,
        array $metadata = []
    ): AttendanceWorklog {
        return DB::transaction(function () use ($worklog, $targetStatus, $actor, $remarks, $metadata) {
            $currentStatus = $worklog->worklog_status;

            // 1. Verify structural state flow
            if (! $this->isValidTransition($currentStatus, $targetStatus)) {
                throw new BusinessRuleViolationException(
                    "Invalid state transition from {$currentStatus->label()} to {$targetStatus->label()}.",
                    'INVALID_STATE_TRANSITION'
                );
            }

            // 2. Authorization and Permission checks
            $this->authorizeTransition($worklog, $targetStatus, $actor);

            // 3. Update worklog record fields depending on target status
            $updates = [
                'worklog_status' => $targetStatus->value,
                'updated_by' => $actor->id,
            ];

            if ($targetStatus === WorkflowStatusEnum::Submitted) {
                $updates['submitted_at'] = now();
            } elseif ($targetStatus === WorkflowStatusEnum::Approved) {
                $updates['approved_by'] = $actor->id;
                $updates['approved_at'] = now();
            } elseif ($targetStatus === WorkflowStatusEnum::Rejected) {
                $updates['rejected_by'] = $actor->id;
                $updates['rejected_at'] = now();
                $updates['rejection_reason'] = $remarks;
            }

            $worklog->update($updates);

            // 4. Record history trail
            $worklog->statusHistories()->create([
                'old_status' => $currentStatus->value,
                'new_status' => $targetStatus->value,
                'changed_by' => $actor->id,
                'remarks' => $remarks,
                'metadata' => $metadata,
            ]);

            return $worklog->fresh();
        });
    }

    /**
     * Authorize transition based on user role/permissions and ownership.
     */
    private function authorizeTransition(AttendanceWorklog $worklog, WorkflowStatusEnum $target, User $actor): void
    {
        $isOwner = $worklog->user_id === $actor->id;

        // Draft -> Submitted or Cancelled is allowed for owner
        if (($target === WorkflowStatusEnum::Submitted || $target === WorkflowStatusEnum::Cancelled) && $isOwner) {
            return;
        }

        // Manager / Admin transitions require permission checks under Spatie Team scoping
        setPermissionsTeamId($worklog->organization_id);

        try {
            // Check platform bypass
            $platformRole = resolve_platform_role($actor);
            $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

            if ($isAppOwner) {
                return;
            }

            // Regular managers must have permission
            if ($actor->hasPermissionTo('attendance_worklogs_update_status')) {
                return;
            }
        } finally {
            setPermissionsTeamId(null);
        }

        throw new UnauthorizedException(403, "You do not have permission to transition this worklog to {$target->label()}.");
    }
}
