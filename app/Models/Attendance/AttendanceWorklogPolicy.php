<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceWorklogPolicy extends Model
{
    protected $table = 'attendance_worklog_policies';

    protected $fillable = [
        'attendance_policy_id',
        'require_worklog_on_clockout',
        'allow_deferred_submission',
        'require_project_mapping',
        'require_task_mapping',
        'require_justification_on_overflow',
        'auto_escalate_overdue_logs',
        'overdue_after_days',
        'lock_after_days',
        'allow_multiple_worklogs_per_session',
        'strict_mode_enabled',
        'flexible_mode_enabled',
        'hybrid_mode_enabled',
    ];

    protected function casts(): array
    {
        return [
            'require_worklog_on_clockout' => 'boolean',
            'allow_deferred_submission' => 'boolean',
            'require_project_mapping' => 'boolean',
            'require_task_mapping' => 'boolean',
            'require_justification_on_overflow' => 'boolean',
            'auto_escalate_overdue_logs' => 'boolean',
            'overdue_after_days' => 'integer',
            'lock_after_days' => 'integer',
            'allow_multiple_worklogs_per_session' => 'boolean',
            'strict_mode_enabled' => 'boolean',
            'flexible_mode_enabled' => 'boolean',
            'hybrid_mode_enabled' => 'boolean',
        ];
    }

    public function attendancePolicy(): BelongsTo
    {
        return $this->belongsTo(AttendancePolicy::class);
    }
}
