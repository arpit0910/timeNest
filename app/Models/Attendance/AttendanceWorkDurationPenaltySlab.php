<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AttendanceWorkDurationPenaltySlab model — short hours penalty settings.
 */
class AttendanceWorkDurationPenaltySlab extends Model
{
    use HasUuid;

    protected $table = 'attendance_work_duration_penalty_slabs';

    protected $fillable = [
        'attendance_policy_id',
        'min_work_minutes',
        'max_work_minutes',
        'deduction_percentage',
    ];

    protected function casts(): array
    {
        return [
            'min_work_minutes' => 'integer',
            'max_work_minutes' => 'integer',
            'deduction_percentage' => 'decimal:2',
        ];
    }

    public function attendancePolicy(): BelongsTo
    {
        return $this->belongsTo(AttendancePolicy::class);
    }
}
