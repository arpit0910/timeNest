<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorklogPolicy extends Model
{
    use HasFactory, HasUuid;

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

    protected function casts(): array
    {
        return [
            'require_worklog_on_clockout' => 'boolean',
            'allow_deferred_submission' => 'boolean',
            'submission_window_days' => 'integer',
            'edit_grace_days' => 'integer',
            'lock_after_days' => 'integer',
            'require_description' => 'boolean',
            'min_description_length' => 'integer',
            'require_justification_on_overflow' => 'boolean',
            'require_project_mapping' => 'boolean',
            'require_task_mapping' => 'boolean',
            'allow_multiple_worklogs_per_session' => 'boolean',
            'auto_escalate_overdue_logs' => 'boolean',
            'billable_tracking_enabled' => 'boolean',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Organization\Organization::class);
    }
}
