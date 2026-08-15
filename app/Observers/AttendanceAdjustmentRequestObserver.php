<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\AttendanceAdjustmentStatusEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\SystemPermission;
use App\Models\Attendance\AttendanceAdjustmentRequest;

/**
 * Raises in-app notifications for the adjustment request lifecycle: the
 * approvers hear about a new request, the requester hears the decision.
 */
class AttendanceAdjustmentRequestObserver
{
    public function created(AttendanceAdjustmentRequest $adjustment): void
    {
        $organizationId = $adjustment->attendanceDay?->organization_id;

        if ($organizationId === null) {
            return;
        }

        $requester = $adjustment->requestedBy?->name ?? 'A team member';
        $date = $adjustment->attendanceDay?->attendance_date?->format('d M');

        notify_approvers(
            (int) $adjustment->requested_by,
            (int) $organizationId,
            SystemPermission::ATTENDANCE_APPROVE_ANY,
            NotificationTypeEnum::ATTENDANCE_ADJUSTMENT_REQUESTED,
            [
                'body' => $date
                    ? "{$requester} requested an attendance adjustment for {$date}."
                    : "{$requester} requested an attendance adjustment.",
                'action_url' => "/attendance/adjustments/{$adjustment->uuid}",
                'subject' => $adjustment,
                'actor' => (int) $adjustment->requested_by,
                'data' => ['adjustment_uuid' => $adjustment->uuid],
            ],
        );
    }

    public function updated(AttendanceAdjustmentRequest $adjustment): void
    {
        if (! $adjustment->isDirty('status')) {
            return;
        }

        $organizationId = $adjustment->attendanceDay?->organization_id;

        if ($organizationId === null) {
            return;
        }

        $status = $adjustment->status instanceof \BackedEnum
            ? (int) $adjustment->status->value
            : (int) $adjustment->status;

        $type = match ($status) {
            AttendanceAdjustmentStatusEnum::APPROVED->value => NotificationTypeEnum::ATTENDANCE_ADJUSTMENT_APPROVED,
            AttendanceAdjustmentStatusEnum::REJECTED->value => NotificationTypeEnum::ATTENDANCE_ADJUSTMENT_REJECTED,
            default => null,
        };

        if ($type === null) {
            return;
        }

        $date = $adjustment->attendanceDay?->attendance_date?->format('d M');
        $suffix = $date ? " for {$date}" : '';

        notify_user((int) $adjustment->requested_by, $type, [
            'body' => $type === NotificationTypeEnum::ATTENDANCE_ADJUSTMENT_APPROVED
                ? "Your attendance adjustment{$suffix} was approved."
                : trim("Your attendance adjustment{$suffix} was rejected. ".($adjustment->rejection_reason ?? '')),
            'organization_id' => (int) $organizationId,
            'action_url' => "/attendance/adjustments/{$adjustment->uuid}",
            'subject' => $adjustment,
            'actor' => $adjustment->resolved_by !== null ? (int) $adjustment->resolved_by : auth()->id(),
            'data' => ['adjustment_uuid' => $adjustment->uuid],
        ]);
    }
}
