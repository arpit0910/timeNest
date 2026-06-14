<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Enums\Leave\AccrualFrequency;
use App\Enums\Leave\ApprovalFlow;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeavePolicyVersion extends Model
{
    protected $table = 'leave_policy_versions';

    public $timestamps = false;

    protected $fillable = [
        'leave_policy_id',
        'version',
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
        'created_at',
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
        'created_at' => 'datetime',
    ];

    public function policy(): BelongsTo
    {
        return $this->belongsTo(LeavePolicy::class, 'leave_policy_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
