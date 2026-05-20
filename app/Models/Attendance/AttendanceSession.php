<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\AttendanceSessionSourceEnum;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * AttendanceSession model — raw clock-in/out records.
 */
class AttendanceSession extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'attendance_sessions';

    protected $fillable = [
        'attendance_day_id',
        'clock_in_at',
        'clock_out_at',
        'clock_in_ip',
        'clock_out_ip',
        'clock_in_device_id',
        'clock_out_device_id',
        'clock_in_accuracy',
        'clock_out_accuracy',
        'clock_in_latitude',
        'clock_in_longitude',
        'clock_out_latitude',
        'clock_out_longitude',
        'clock_in_source',
        'clock_out_source',
        'is_suspicious',
        'suspicious_reason',
    ];

    protected function casts(): array
    {
        return [
            'clock_in_at' => 'datetime',
            'clock_out_at' => 'datetime',
            'clock_in_accuracy' => 'decimal:2',
            'clock_out_accuracy' => 'decimal:2',
            'clock_in_latitude' => 'decimal:7',
            'clock_in_longitude' => 'decimal:7',
            'clock_out_latitude' => 'decimal:7',
            'clock_out_longitude' => 'decimal:7',
            'clock_in_source' => AttendanceSessionSourceEnum::class,
            'clock_out_source' => AttendanceSessionSourceEnum::class,
            'is_suspicious' => 'boolean',
        ];
    }

    public function attendanceDay(): BelongsTo
    {
        return $this->belongsTo(AttendanceDay::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeSuspicious(Builder $query): Builder
    {
        return $query->where('is_suspicious', true);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('clock_in_at', now()->toDateString());
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
