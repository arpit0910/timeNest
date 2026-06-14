<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Enums\Leave\LeaveStatus;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\HasUuid;

class LeaveStatusHistory extends Model
{
    use HasUuid;

    protected $table = 'leave_status_histories';

    public $timestamps = false;

    protected $fillable = [
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
            'old_status' => LeaveStatus::class,
            'new_status' => LeaveStatus::class,
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function employeeLeave(): BelongsTo
    {
        return $this->belongsTo(EmployeeLeave::class, 'employee_leave_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
