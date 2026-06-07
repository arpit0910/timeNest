<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Models\Organization\Organization;
use App\Models\Auth\User;
use App\Models\Project\Project;
use App\Models\Project\Milestone;
use App\Models\Project\Task;
use App\Models\Project\TaskTimeConsumption;
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
        'worklog_status',
        'compliance_status',
        'start_time',
        'end_time',
        'logged_minutes',
        'description',
        'justification',
        'submitted_at',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'rejection_reason',
        'metadata',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'worklog_status' => \App\Enums\WorkflowStatusEnum::class,
            'compliance_status' => \App\Enums\WorklogComplianceStatusEnum::class,
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'metadata' => 'array',
            'logged_minutes' => 'integer',
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
        return $this->hasMany(WorklogStatusHistory::class);
    }

    public function timeConsumptions(): HasMany
    {
        return $this->hasMany(TaskTimeConsumption::class);
    }
}
