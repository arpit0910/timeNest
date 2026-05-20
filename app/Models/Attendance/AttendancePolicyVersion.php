<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\AttendanceModeEnum;
use App\Models\Auth\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AttendancePolicyVersion model — immutable payroll-safe policy snapshot.
 */
class AttendancePolicyVersion extends Model
{
    use HasUuid;

    protected $table = 'attendance_policy_versions';

    protected $fillable = [
        'attendance_policy_id',
        'version',
        'attendance_mode',
        'required_daily_minutes',
        'minimum_session_minutes',
        'grace_late_minutes',
        'allowed_monthly_late_count',
        'default_break_minutes',
        'worklog_submission_window_days',
        'worklog_edit_grace_days',
        'allow_multiple_sessions',
        'allow_clock_in_on_holidays',
        'auto_clock_out_enabled',
        'auto_clock_out_minutes',
        'strict_worklog_enforcement',
        'shift_start_time',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'attendance_mode' => AttendanceModeEnum::class,
            'version' => 'integer',
            'required_daily_minutes' => 'integer',
            'minimum_session_minutes' => 'integer',
            'grace_late_minutes' => 'integer',
            'allowed_monthly_late_count' => 'integer',
            'default_break_minutes' => 'integer',
            'worklog_submission_window_days' => 'integer',
            'worklog_edit_grace_days' => 'integer',
            'allow_multiple_sessions' => 'boolean',
            'allow_clock_in_on_holidays' => 'boolean',
            'auto_clock_out_enabled' => 'boolean',
            'auto_clock_out_minutes' => 'integer',
            'strict_worklog_enforcement' => 'boolean',
            'created_by' => 'integer',
        ];
    }

    public function attendancePolicy(): BelongsTo
    {
        return $this->belongsTo(AttendancePolicy::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
