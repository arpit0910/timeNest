<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\LeaveStatusEnum;
use App\Enums\LeaveTypeEnum;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * EmployeeLeave model — WFH, EWD, and standard leaves.
 */
class EmployeeLeave extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'employee_leaves';

    protected $appends = [
        'status_label',
    ];

    protected $fillable = [
        'organization_id',
        'user_id',
        'leave_type',
        'leave_status',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'attachment_path',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'cancellation_reason',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'leave_type' => LeaveTypeEnum::class,
            'leave_status' => LeaveStatusEnum::class,
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
            'total_days' => 'decimal:2',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(LeaveStatusHistory::class, 'employee_leave_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->leave_status ? $this->leave_status->label() : '';
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public function isApproved(): bool
    {
        return $this->leave_status ? $this->leave_status->isApproved() : false;
    }

    public function isRejected(): bool
    {
        return $this->leave_status ? $this->leave_status->isRejected() : false;
    }

    public function isWFH(): bool
    {
        return $this->leave_type ? $this->leave_type->isWFH() : false;
    }

    public function isEWD(): bool
    {
        return $this->leave_type ? $this->leave_type->isEWD() : false;
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereIn('leave_status', [LeaveStatusEnum::Approved, LeaveStatusEnum::AutoApproved]);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('leave_status', LeaveStatusEnum::Pending);
    }

    public function scopeToday(Builder $query): Builder
    {
        $today = now()->toDateString();
        return $query->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
