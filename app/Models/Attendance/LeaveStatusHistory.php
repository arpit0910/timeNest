<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Enums\LeaveStatusEnum;
use App\Models\Auth\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveStatusHistory extends Model
{
    use HasUuid;

    protected $table = 'leave_status_histories';

    // No default updated_at column in our migration (only created_at as timestamp)
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'employee_leave_id',
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
            'old_status' => LeaveStatusEnum::class,
            'new_status' => LeaveStatusEnum::class,
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function leave(): BelongsTo
    {
        return $this->belongsTo(EmployeeLeave::class, 'employee_leave_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
