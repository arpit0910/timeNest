<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\Attendance\ApprovalFlow;
use App\Enums\Attendance\AttendanceMode;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendancePolicyVersion extends Model
{
    use HasFactory;

    protected $table = 'attendance_policy_versions';

    public $timestamps = false;

    protected $fillable = [
        'attendance_policy_id',
        'version',
        'created_by',
        'organization_id',
        'attendance_mode',
        'approval_flow',
        'shift_start_time',
        'shift_end_time',
        'required_daily_minutes',
        'minimum_session_minutes',
        'grace_late_minutes',
        'allowed_monthly_late_count',
        'allow_early_exit',
        'grace_early_exit_minutes',
        'default_break_minutes',
        'max_break_minutes',
        'allow_multiple_sessions',
        'allow_clock_in_on_holidays',
        'auto_clock_out_enabled',
        'auto_clock_out_after_minutes',
        'overtime_enabled',
        'overtime_starts_after_minutes',
        'max_daily_overtime_minutes',
        'overtime_requires_approval',
        'weekend_days',
        'geo_fencing_enabled',
        'geo_fence_radius_meters',
        'ip_restriction_enabled',
        'strict_worklog_enforcement',
        'created_at',
    ];

    protected $casts = [
        'attendance_mode' => AttendanceMode::class,
        'approval_flow' => ApprovalFlow::class,
        'weekend_days' => 'array',
        'allow_early_exit' => 'boolean',
        'allow_multiple_sessions' => 'boolean',
        'allow_clock_in_on_holidays' => 'boolean',
        'auto_clock_out_enabled' => 'boolean',
        'overtime_enabled' => 'boolean',
        'overtime_requires_approval' => 'boolean',
        'geo_fencing_enabled' => 'boolean',
        'ip_restriction_enabled' => 'boolean',
        'strict_worklog_enforcement' => 'boolean',
    ];

    public function policy(): BelongsTo
    {
        return $this->belongsTo(AttendancePolicy::class, 'attendance_policy_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
