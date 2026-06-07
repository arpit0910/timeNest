<?php

declare(strict_types=1);

namespace App\Observers;

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
}
