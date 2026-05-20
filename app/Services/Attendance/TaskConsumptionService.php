<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Models\Attendance\AttendanceWorklog;
use App\Models\Project\TaskTimeConsumption;

class TaskConsumptionService
{
    /**
     * Sync consumption record for a given worklog.
     */
    public function syncConsumption(AttendanceWorklog $worklog): void
    {
        if (! $worklog->task_id || $worklog->logged_minutes <= 0) {
            $this->deleteConsumption($worklog);
            return;
        }

        TaskTimeConsumption::updateOrCreate([
            'attendance_worklog_id' => $worklog->id,
        ], [
            'task_id' => $worklog->task_id,
            'consumed_minutes' => $worklog->logged_minutes,
            'created_at' => now(),
        ]);
    }

    /**
     * Delete consumption record for a given worklog.
     */
    public function deleteConsumption(AttendanceWorklog $worklog): void
    {
        TaskTimeConsumption::where('attendance_worklog_id', $worklog->id)->delete();
    }
}
