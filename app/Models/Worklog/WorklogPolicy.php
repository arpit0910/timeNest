<?php

declare(strict_types=1);

namespace App\Models\Worklog;

use App\Enums\Worklog\ApprovalFlow;
use App\Enums\Worklog\WorklogMode;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WorklogPolicy extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'worklog_policies';

    protected $fillable = [
        'organization_id',
        'worklog_mode',
        'approval_flow',
        'require_worklog_on_clockout',
        'allow_deferred_submission',
        'submission_window_days',
        'edit_grace_days',
        'lock_after_days',
        'require_description',
        'min_description_length',
        'require_justification_on_overflow',
        'require_project_mapping',
        'require_task_mapping',
        'allow_multiple_worklogs_per_session',
        'auto_escalate_overdue_logs',
        'billable_tracking_enabled',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'worklog_mode' => WorklogMode::class,
        'approval_flow' => ApprovalFlow::class,
        'require_worklog_on_clockout' => 'boolean',
        'allow_deferred_submission' => 'boolean',
        'require_description' => 'boolean',
        'require_justification_on_overflow' => 'boolean',
        'require_project_mapping' => 'boolean',
        'require_task_mapping' => 'boolean',
        'allow_multiple_worklogs_per_session' => 'boolean',
        'auto_escalate_overdue_logs' => 'boolean',
        'billable_tracking_enabled' => 'boolean',
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
        return $this->hasMany(WorklogPolicyVersion::class, 'worklog_policy_id');
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
