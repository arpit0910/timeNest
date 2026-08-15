<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\EscalationStatusEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\SystemPermission;
use App\Models\Attendance\AttendanceEscalation;

/**
 * Escalations are raised by the system, not a person, so both the employee
 * concerned and whoever can resolve it are told.
 */
class AttendanceEscalationObserver
{
    public function created(AttendanceEscalation $escalation): void
    {
        $reason = $escalation->escalation_type?->label() ?? 'An attendance issue';

        notify_user($escalation->user_id, NotificationTypeEnum::ATTENDANCE_ESCALATION_RAISED, [
            'body' => "{$reason} was flagged on your attendance.",
            'organization_id' => $escalation->organization_id,
            'action_url' => "/attendance/escalations/{$escalation->uuid}",
            'subject' => $escalation,
            'data' => ['escalation_uuid' => $escalation->uuid],
        ]);

        $employee = $escalation->user?->name ?? 'A team member';

        notify_approvers(
            $escalation->user_id,
            $escalation->organization_id,
            SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
            NotificationTypeEnum::ATTENDANCE_ESCALATION_RAISED,
            [
                'title' => 'Attendance escalation needs review',
                'body' => "{$reason} was flagged for {$employee}.",
                'action_url' => "/attendance/escalations/{$escalation->uuid}",
                'subject' => $escalation,
                'actor' => $escalation->user_id,
                'data' => ['escalation_uuid' => $escalation->uuid],
            ],
        );
    }

    public function updated(AttendanceEscalation $escalation): void
    {
        if (! $escalation->isDirty('escalation_status')) {
            return;
        }

        $status = $escalation->escalation_status instanceof \BackedEnum
            ? (int) $escalation->escalation_status->value
            : (int) $escalation->escalation_status;

        if (! in_array($status, [EscalationStatusEnum::RESOLVED->value, EscalationStatusEnum::DISMISSED->value], true)) {
            return;
        }

        $outcome = $status === EscalationStatusEnum::RESOLVED->value ? 'resolved' : 'dismissed';

        notify_user($escalation->user_id, NotificationTypeEnum::ATTENDANCE_ESCALATION_RESOLVED, [
            'title' => 'Attendance escalation '.$outcome,
            'body' => "The attendance escalation on your record was {$outcome}.",
            'organization_id' => $escalation->organization_id,
            'action_url' => "/attendance/escalations/{$escalation->uuid}",
            'subject' => $escalation,
            'actor' => $escalation->resolved_by !== null ? (int) $escalation->resolved_by : auth()->id(),
            'data' => ['escalation_uuid' => $escalation->uuid],
        ]);
    }
}
