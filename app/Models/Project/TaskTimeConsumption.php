<?php

declare(strict_types=1);

namespace App\Models\Project;

use App\Models\Attendance\AttendanceWorklog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskTimeConsumption extends Model
{
    protected $table = 'task_time_consumptions';

    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'attendance_worklog_id',
        'consumed_minutes',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'consumed_minutes' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function worklog(): BelongsTo
    {
        return $this->belongsTo(AttendanceWorklog::class, 'attendance_worklog_id');
    }
}
