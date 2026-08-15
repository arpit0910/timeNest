<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Leave\LeaveStatus;
use App\Enums\NotificationTypeEnum;
use App\Enums\SystemPermission;
use App\Models\Leave\EmployeeLeave;
use App\Models\Attendance\AttendanceActivityLog;
use Illuminate\Support\Str;

class EmployeeLeaveObserver
{
    /**
     * Handle the EmployeeLeave "created" event.
     */
    public function created(EmployeeLeave $leave): void
    {
        $actorId = auth()->id() ?? $leave->user_id;

        $this->notifyCreated($leave);

        AttendanceActivityLog::create([
            'organization_id' => $leave->organization_id,
            'user_id' => $leave->user_id,
            'actor_id' => $actorId,
            'action' => 'leave_created',
            'old_values' => null,
            'new_values' => [
                'leave_type' => $leave->leave_type?->value,
                'leave_status' => $leave->leave_status?->value,
                'start_date' => $leave->start_date?->toDateString(),
                'end_date' => $leave->end_date?->toDateString(),
                'total_days' => (float) $leave->total_days,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Handle the EmployeeLeave "updated" event.
     */
    public function updated(EmployeeLeave $leave): void
    {
        if ($leave->isDirty('leave_status')) {
            $actorId = auth()->id() ?? $leave->user_id;

            $this->notifyStatusChanged($leave, $actorId);

            $oldStatus = $leave->getOriginal('leave_status');
            $newStatus = $leave->leave_status;

            // Resolve raw value if it is an enum or integer
            $oldVal = $oldStatus instanceof \BackedEnum ? $oldStatus->value : $oldStatus;
            $newVal = $newStatus instanceof \BackedEnum ? $newStatus->value : $newStatus;

            AttendanceActivityLog::create([
                'organization_id' => $leave->organization_id,
                'user_id' => $leave->user_id,
                'actor_id' => $actorId,
                'action' => 'leave_status_changed',
                'old_values' => ['leave_status' => $oldVal],
                'new_values' => ['leave_status' => $newVal],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * A newly submitted request needs its approvers to know about it. Drafts
     * are not yet anyone else's business.
     */
    private function notifyCreated(EmployeeLeave $leave): void
    {
        $status = $this->statusValue($leave->leave_status);

        if ($status !== LeaveStatus::PENDING->value) {
            return;
        }

        $range = $this->dateRange($leave);
        $applicant = $leave->user?->name ?? 'A team member';

        notify_approvers(
            $leave->user_id,
            $leave->organization_id,
            SystemPermission::LEAVES_APPROVE_ANY,
            NotificationTypeEnum::LEAVE_PENDING_APPROVAL,
            [
                'title' => 'Leave request awaiting your approval',
                'body' => "{$applicant} requested leave for {$range}.",
                'action_url' => "/leave/{$leave->uuid}",
                'subject' => $leave,
                'actor' => $leave->user_id,
                'data' => ['leave_uuid' => $leave->uuid],
            ],
        );
    }

    /**
     * Status transitions notify the person whose leave it is. The actor is
     * skipped automatically, so someone cancelling their own leave is not
     * told about it.
     */
    private function notifyStatusChanged(EmployeeLeave $leave, ?int $actorId): void
    {
        $status = $this->statusValue($leave->leave_status);
        $range = $this->dateRange($leave);

        $type = match ($status) {
            LeaveStatus::APPROVED->value, LeaveStatus::AUTO_APPROVED->value => NotificationTypeEnum::LEAVE_APPROVED,
            LeaveStatus::REJECTED->value => NotificationTypeEnum::LEAVE_REJECTED,
            LeaveStatus::CANCELLED->value => NotificationTypeEnum::LEAVE_CANCELLED,
            LeaveStatus::PENDING->value => NotificationTypeEnum::LEAVE_SUBMITTED,
            default => null,
        };

        if ($type === null) {
            return;
        }

        // A request moving into PENDING is a submission — tell the approvers,
        // not the applicant.
        if ($type === NotificationTypeEnum::LEAVE_SUBMITTED) {
            $this->notifyCreated($leave);

            return;
        }

        $body = match ($type) {
            NotificationTypeEnum::LEAVE_APPROVED => "Your leave for {$range} was approved.",
            NotificationTypeEnum::LEAVE_REJECTED => trim("Your leave for {$range} was rejected. ".($leave->rejection_reason ?? '')),
            NotificationTypeEnum::LEAVE_CANCELLED => "Your leave for {$range} was cancelled.",
            default => null,
        };

        notify_user($leave->user_id, $type, [
            'body' => $body,
            'organization_id' => $leave->organization_id,
            'action_url' => "/leave/{$leave->uuid}",
            'subject' => $leave,
            'actor' => $actorId,
            'data' => ['leave_uuid' => $leave->uuid],
        ]);
    }

    /** "20 Aug – 22 Aug", or a single date when the range is one day. */
    private function dateRange(EmployeeLeave $leave): string
    {
        $start = $leave->start_date?->format('d M');
        $end = $leave->end_date?->format('d M');

        if ($start === null) {
            return 'the requested dates';
        }

        return ($end === null || $end === $start) ? $start : "{$start} – {$end}";
    }

    private function statusValue(mixed $status): ?int
    {
        return $status instanceof \BackedEnum ? (int) $status->value : ($status === null ? null : (int) $status);
    }
}
