<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceWorklogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->route('dayUuid')) {
            $this->merge([
                'attendance_day_uuid' => $this->route('dayUuid'),
            ]);
        }
    }

    public function rules(): array
    {
        // Worklogs may only be logged for today or within the last 15 days —
        // never for a future date. Computed per-request (not a constant) so
        // "today" is always evaluated at the moment of submission.
        $earliestAllowed = now()->subDays(15)->startOfDay()->format('Y-m-d H:i:s');
        $latestAllowed = now()->endOfDay()->format('Y-m-d H:i:s');

        return [
            'attendance_day_uuid' => 'required|string|exists:attendance_days,uuid',
            'attendance_session_uuid' => 'nullable|string|exists:attendance_sessions,uuid',
            'project_uuid' => 'nullable|string|exists:projects,uuid',
            'milestone_uuid' => 'nullable|string|exists:milestones,uuid',
            'task_uuid' => 'nullable|string|exists:tasks,uuid',
            'start_time' => [
                'nullable',
                'date_format:Y-m-d H:i:s',
                "after_or_equal:{$earliestAllowed}",
                "before_or_equal:{$latestAllowed}",
            ],
            'end_time' => [
                'nullable',
                'date_format:Y-m-d H:i:s',
                'after:start_time',
                "before_or_equal:{$latestAllowed}",
            ],
            'logged_minutes' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'justification' => 'nullable|string',
            'metadata' => 'nullable|array',
        ];
    }
}
