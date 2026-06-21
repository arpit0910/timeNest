<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\AttendanceAdjustmentStatusEnum;
use App\Enums\AttendanceAdjustmentTypeEnum;
use App\Models\Auth\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * AttendanceAdjustmentRequest model — immutable correction records.
 */
class AttendanceAdjustmentRequest extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'attendance_adjustment_requests';

    protected $fillable = [
        'attendance_day_id',
        'attendance_session_id',
        'requested_by',
        'adjustment_type',
        'status',
        'details',
        'resolved_by',
        'resolved_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'adjustment_type' => AttendanceAdjustmentTypeEnum::class,
            'status' => AttendanceAdjustmentStatusEnum::class,
            'details' => 'array',
            'resolved_at' => 'datetime',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function attendanceDay(): BelongsTo
    {
        return $this->belongsTo(AttendanceDay::class);
    }

    public function attendanceSession(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === AttendanceAdjustmentStatusEnum::PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === AttendanceAdjustmentStatusEnum::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === AttendanceAdjustmentStatusEnum::REJECTED;
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', AttendanceAdjustmentStatusEnum::PENDING);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', AttendanceAdjustmentStatusEnum::APPROVED);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
