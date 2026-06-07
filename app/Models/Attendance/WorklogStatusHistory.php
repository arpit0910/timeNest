<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Models\Auth\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorklogStatusHistory extends Model
{
    use HasUuid;

    protected $table = 'worklog_status_histories';

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'attendance_worklog_id',
        'old_status',
        'new_status',
        'changed_by',
        'remarks',
        'metadata',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_status' => \App\Enums\WorkflowStatusEnum::class,
            'new_status' => \App\Enums\WorkflowStatusEnum::class,
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function worklog(): BelongsTo
    {
        return $this->belongsTo(AttendanceWorklog::class, 'attendance_worklog_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
