<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Models\Corporation\Corporation;
use App\Models\Auth\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceEscalation extends Model
{
    use HasUuid;

    protected $table = 'attendance_escalations';

    protected $fillable = [
        'corporation_id',
        'user_id',
        'attendance_day_id',
        'attendance_worklog_id',
        'escalation_type',
        'escalation_level',
        'escalation_status',
        'remarks',
        'metadata',
        'resolved_by',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'escalation_type' => \App\Enums\EscalationTypeEnum::class,
            'escalation_status' => \App\Enums\EscalationStatusEnum::class,
            'metadata' => 'array',
            'resolved_at' => 'datetime',
            'escalation_level' => 'integer',
        ];
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendanceDay(): BelongsTo
    {
        return $this->belongsTo(AttendanceDay::class);
    }

    public function attendanceWorklog(): BelongsTo
    {
        return $this->belongsTo(AttendanceWorklog::class);
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
