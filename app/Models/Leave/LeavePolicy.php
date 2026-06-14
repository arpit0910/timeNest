<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Enums\Leave\AccrualFrequency;
use App\Enums\Leave\ApprovalFlow;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LeavePolicy extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leave_policies';

    protected $fillable = [
        'organization_id',
        'approval_flow',
        'allow_half_day_leaves',
        'allow_leave_on_weekends',
        'allow_leave_on_holidays',
        'advance_notice_required_days',
        'max_advance_application_days',
        'document_required_after_days',
        'allow_leave_cancellation',
        'cancellation_before_hours',
        'carry_forward_enabled',
        'max_carry_forward_days',
        'carry_forward_expiry_months',
        'accrual_enabled',
        'accrual_frequency',
        'negative_balance_allowed',
        'auto_approve_after_hours',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'approval_flow' => ApprovalFlow::class,
        'accrual_frequency' => AccrualFrequency::class,
        'allow_half_day_leaves' => 'boolean',
        'allow_leave_on_weekends' => 'boolean',
        'allow_leave_on_holidays' => 'boolean',
        'allow_leave_cancellation' => 'boolean',
        'carry_forward_enabled' => 'boolean',
        'accrual_enabled' => 'boolean',
        'negative_balance_allowed' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(LeavePolicyVersion::class, 'leave_policy_id');
    }

    public function leaveTypes(): HasMany
    {
        return $this->hasMany(LeaveType::class, 'leave_policy_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
