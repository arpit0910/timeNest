<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\WorklogComplianceStatusEnum;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Attendance\AttendanceWorklogPolicy;
use App\Models\Project\TaskTimeConsumption;
use Carbon\Carbon;

class AttendanceWorklogCalculationService
{
    /**
     * Calculate logged minutes based on start and end times if available,
     * otherwise return the explicitly logged minutes.
     */
    public function calculateLoggedMinutes(array $data): int
    {
        $startTime = $data['start_time'] ?? null;
        $endTime = $data['end_time'] ?? null;

        if ($startTime && $endTime) {
            $start = Carbon::parse($startTime);
            $end = Carbon::parse($endTime);
            return (int) $start->diffInMinutes($end, true);
        }

        return (int) ($data['logged_minutes'] ?? 0);
    }

    /**
     * Determine compliance status for a worklog.
     */
    public function determineComplianceStatus(
        AttendanceWorklog $worklog,
        AttendanceWorklogPolicy $policy
    ): WorklogComplianceStatusEnum {
        if (! $worklog->task_id) {
            return WorklogComplianceStatusEnum::Compliant;
        }

        $task = $worklog->task;
        if (! $task || $task->estimated_minutes <= 0) {
            return WorklogComplianceStatusEnum::Compliant;
        }

        // Sum other consumptions
        $existingConsumption = (int) TaskTimeConsumption::where('task_id', $task->id)
            ->where('attendance_worklog_id', '!=', $worklog->id)
            ->sum('consumed_minutes');

        if ($existingConsumption + $worklog->logged_minutes > $task->estimated_minutes) {
            return WorklogComplianceStatusEnum::Overflow;
        }

        return WorklogComplianceStatusEnum::Compliant;
    }
}
