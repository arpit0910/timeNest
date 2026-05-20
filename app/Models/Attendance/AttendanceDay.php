<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\AttendanceComplianceStatusEnum;
use App\Enums\AttendanceStatusEnum;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * AttendanceDay model — daily attendance aggregates.
 */
class AttendanceDay extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'attendance_days';

    protected $fillable = [
        'user_id',
        'corporation_id',
        'attendance_date',
        'attendance_status',
        'compliance_status',
        'total_work_minutes',
        'total_break_minutes',
        'total_sessions',
        'late_minutes',
        'overtime_minutes',
        'attendance_policy_version_id',
    ];

    protected $appends = [
        'status_label',
        'formatted_duration',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date:Y-m-d',
            'attendance_status' => AttendanceStatusEnum::class,
            'compliance_status' => AttendanceComplianceStatusEnum::class,
            'total_work_minutes' => 'integer',
            'total_break_minutes' => 'integer',
            'total_sessions' => 'integer',
            'late_minutes' => 'integer',
            'overtime_minutes' => 'integer',
            'attendance_policy_version_id' => 'integer',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function policyVersion(): BelongsTo
    {
        return $this->belongsTo(AttendancePolicyVersion::class, 'attendance_policy_version_id');
    }

    public function adjustments(): HasMany
    {
        return $this->hasMany(AttendanceAdjustmentRequest::class);
    }

    // ─── Accessors (Appendable attributes) ───────────────────────

    public function getStatusLabelAttribute(): string
    {
        return $this->attendance_status ? $this->attendance_status->label() : '';
    }

    public function getFormattedDurationAttribute(): string
    {
        $minutes = $this->total_work_minutes ?? 0;
        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        return sprintf('%02dh %02dm', $hours, $remainingMinutes);
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeToday(Builder $query): Builder
    {
        return $query->where('attendance_date', now()->toDateString());
    }

    public function scopeSuspicious(Builder $query): Builder
    {
        return $query->whereHas('attendanceSessions', function (Builder $q) {
            $q->where('is_suspicious', true);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        // For soft delete compatibility
        return $query->whereNull('deleted_at');
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForCorporation(Builder $query, int $corpId): Builder
    {
        return $query->where('corporation_id', $corpId);
    }
}
