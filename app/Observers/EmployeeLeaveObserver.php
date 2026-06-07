<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Attendance\EmployeeLeave;
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
}
