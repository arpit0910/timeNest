<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\NotificationTypeEnum;
use App\Enums\SystemPermission;
use App\Enums\WorkflowStatusEnum;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Attendance\AttendanceActivityLog;

class AttendanceWorklogObserver
{
    /**
     * Handle the AttendanceWorklog "created" event.
     */
    public function created(AttendanceWorklog $worklog): void
    {
        $actorId = auth()->id() ?? $worklog->user_id;

        AttendanceActivityLog::create([
            'organization_id' => $worklog->organization_id,
            'user_id' => $worklog->user_id,
            'actor_id' => $actorId,
            'action' => 'worklog_created',
            'old_values' => null,
            'new_values' => [
                'worklog_uuid' => $worklog->uuid,
                'logged_minutes' => $worklog->logged_minutes,
                'worklog_status' => $worklog->worklog_status?->value ?? $worklog->worklog_status,
                'compliance_status' => $worklog->compliance_status?->value ?? $worklog->compliance_status,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Handle the AttendanceWorklog "updated" event.
     */
    public function updated(AttendanceWorklog $worklog): void
    {
        $actorId = auth()->id() ?? $worklog->user_id;

        if ($worklog->isDirty('worklog_status')) {
            $this->notifyStatusChanged($worklog, $actorId);

            $oldStatus = $worklog->getOriginal('worklog_status');
            $newStatus = $worklog->worklog_status;

            $oldVal = $oldStatus instanceof \BackedEnum ? $oldStatus->value : $oldStatus;
            $newVal = $newStatus instanceof \BackedEnum ? $newStatus->value : $newStatus;

            AttendanceActivityLog::create([
                'organization_id' => $worklog->organization_id,
                'user_id' => $worklog->user_id,
                'actor_id' => $actorId,
                'action' => 'worklog_status_changed',
                'old_values' => ['worklog_status' => $oldVal],
                'new_values' => ['worklog_status' => $newVal],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Handle the AttendanceWorklog "deleted" event.
     */
    public function deleted(AttendanceWorklog $worklog): void
    {
        $actorId = auth()->id() ?? $worklog->user_id;

        AttendanceActivityLog::create([
            'organization_id' => $worklog->organization_id,
            'user_id' => $worklog->user_id,
            'actor_id' => $actorId,
            'action' => 'worklog_deleted',
            'old_values' => [
                'worklog_uuid' => $worklog->uuid,
            ],
            'new_values' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Submission notifies the approvers; a decision notifies the author.
     * Auto-approval on submit produces both, in that order, which is correct —
     * the author still wants to know it cleared.
     */
    private function notifyStatusChanged(AttendanceWorklog $worklog, ?int $actorId): void
    {
        $status = $worklog->worklog_status instanceof \BackedEnum
            ? (int) $worklog->worklog_status->value
            : (int) $worklog->worklog_status;

        $hours = $worklog->logged_minutes !== null
            ? round($worklog->logged_minutes / 60, 1).'h'
            : null;

        if ($status === WorkflowStatusEnum::SUBMITTED->value) {
            $author = $worklog->user?->name ?? 'A team member';

            notify_approvers(
                $worklog->user_id,
                $worklog->organization_id,
                SystemPermission::WORKLOG_APPROVE_ANY,
                NotificationTypeEnum::WORKLOG_SUBMITTED,
                [
                    'title' => 'Worklog submitted for approval',
                    'body' => $hours
                        ? "{$author} submitted {$hours} of work for approval."
                        : "{$author} submitted a worklog for approval.",
                    'action_url' => "/worklogs/{$worklog->uuid}",
                    'subject' => $worklog,
                    'actor' => $worklog->user_id,
                    'data' => ['worklog_uuid' => $worklog->uuid],
                ],
            );

            return;
        }

        $type = match ($status) {
            WorkflowStatusEnum::APPROVED->value => NotificationTypeEnum::WORKLOG_APPROVED,
            WorkflowStatusEnum::REJECTED->value => NotificationTypeEnum::WORKLOG_REJECTED,
            default => null,
        };

        if ($type === null) {
            return;
        }

        notify_user($worklog->user_id, $type, [
            'body' => $type === NotificationTypeEnum::WORKLOG_APPROVED
                ? ($hours ? "Your {$hours} worklog was approved." : 'Your worklog was approved.')
                : ($hours ? "Your {$hours} worklog was rejected." : 'Your worklog was rejected.'),
            'organization_id' => $worklog->organization_id,
            'action_url' => "/worklogs/{$worklog->uuid}",
            'subject' => $worklog,
            'actor' => $actorId,
            'data' => ['worklog_uuid' => $worklog->uuid],
        ]);
    }
}
