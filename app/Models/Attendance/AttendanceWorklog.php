<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\Attendance\WorklogComplianceStatus;
use App\Enums\Attendance\WorklogStatus;
use App\Enums\Worklog\ApprovalFlow;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Project\Milestone;
use App\Models\Project\Project;
use App\Models\Project\Task;
use App\Models\Project\TaskTimeConsumption;
use App\Models\Worklog\WorklogPolicyVersion;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceWorklog extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'attendance_worklogs';

    protected $fillable = [
        'organization_id',
        'user_id',
        'attendance_day_id',
        'attendance_session_id',
        'project_id',
        'milestone_id',
        'task_id',
        'worklog_policy_version_id',
        'approval_flow_snapshot',
        'worklog_status',
        'compliance_status',
        'start_time',
        'end_time',
        'logged_minutes',
        'description',
        'justification',
        'submitted_at',
        'submitted_by',
        'billable',
        'approved_by',
        'approved_at',
        'second_approver_id',
        'second_approved_at',
        'rejected_by',
        'rejected_at',
        'rejection_reason',
        'second_rejected_by',
        'second_rejected_at',
        'metadata',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'worklog_status' => WorklogStatus::class,
            'compliance_status' => WorklogComplianceStatus::class,
            'approval_flow_snapshot' => ApprovalFlow::class,
            'billable' => 'boolean',
            'logged_minutes' => 'integer',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'second_approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'second_rejected_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendanceDay(): BelongsTo
    {
        return $this->belongsTo(AttendanceDay::class);
    }

    public function attendanceSession(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class);
    }

    public function worklogPolicyVersion(): BelongsTo
    {
        return $this->belongsTo(WorklogPolicyVersion::class, 'worklog_policy_version_id');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
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

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(WorklogStatusHistory::class, 'attendance_worklog_id');
    }

    public function timeConsumptions(): HasMany
    {
        return $this->hasMany(TaskTimeConsumption::class);
    }

    public function isApproved(): bool
    {
        return in_array($this->worklog_status, [WorklogStatus::Approved, WorklogStatus::AutoApproved], true);
    }

    public function isPending(): bool
    {
        return $this->worklog_status === WorklogStatus::Submitted;
    }

    public function isLocked(): bool
    {
        return $this->worklog_status === WorklogStatus::Locked;
    }

    public function hasFirstLevelApproval(): bool
    {
        return $this->approved_by !== null;
    }
}
