<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AttendanceLatePenaltySlab model — late arrival deduction settings.
 */
class AttendanceLatePenaltySlab extends Model
{
    use HasUuid;

    protected $table = 'attendance_late_penalty_slabs';

    protected $fillable = [
        'attendance_policy_id',
        'late_count_threshold',
        'deduction_percentage',
    ];

    protected function casts(): array
    {
        return [
            'late_count_threshold' => 'integer',
            'deduction_percentage' => 'decimal:2',
        ];
    }

    public function attendancePolicy(): BelongsTo
    {
        return $this->belongsTo(AttendancePolicy::class);
    }
}
