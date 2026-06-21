<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Enums\Leave\ApprovalFlow;
use App\Enums\Leave\LeaveStatus;
use App\Enums\Leave\LeaveType as LeaveTypeEnum;
use App\Models\Auth\User;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'leave_type_id',
        'leave_policy_version_id',
        'approval_flow_snapshot',
        'leave_status',
        'start_date',
        'end_date',
        'total_days',
        'is_carry_forward',
        'reason',
        'attachment_path',
        'approved_by',
        'approved_at',
        'auto_approved_at',
        'second_approver_id',
        'second_approved_at',
        'rejected_by',
        'rejected_at',
        'second_rejected_by',
        'second_rejected_at',
        'cancellation_reason',
        'metadata',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'leave_type' => LeaveTypeEnum::class,
            'leave_status' => LeaveStatus::class,
            'approval_flow_snapshot' => ApprovalFlow::class,
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
            'total_days' => 'decimal:2',
            'is_carry_forward' => 'boolean',
            'approved_at' => 'datetime',
            'auto_approved_at' => 'datetime',
            'second_approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'second_rejected_at' => 'datetime',
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

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function policyVersion(): BelongsTo
    {
        return $this->belongsTo(LeavePolicyVersion::class, 'leave_policy_version_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function secondApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'second_approver_id');
    }

    public function secondRejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'second_rejected_by');
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

    public function isPending(): bool
    {
        return $this->leave_status === LeaveStatus::PENDING;
    }

    public function isApproved(): bool
    {
        return in_array($this->leave_status, [LeaveStatus::APPROVED, LeaveStatus::AUTO_APPROVED], true);
    }

    public function isRejected(): bool
    {
        return $this->leave_status === LeaveStatus::REJECTED;
    }

    public function isCancelled(): bool
    {
        return $this->leave_status === LeaveStatus::CANCELLED;
    }

    public function hasFirstLevelApproval(): bool
    {
        return $this->approved_by !== null;
    }

    public function isWFH(): bool
    {
        return $this->leave_type === LeaveTypeEnum::WorkFromHome;
    }

    public function isEWD(): bool
    {
        return $this->leave_type === LeaveTypeEnum::ExtraWorkingDay;
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereIn('leave_status', [LeaveStatus::APPROVED, LeaveStatus::AUTO_APPROVED]);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('leave_status', LeaveStatus::PENDING);
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
