<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AttendanceActivityLog model — immutable audit logs.
 */
class AttendanceActivityLog extends Model
{
    use HasUuid;

    protected $table = 'attendance_activity_logs';

    // Disable updated_at column since it's write-once audit log
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'organization_id',
        'user_id',
        'actor_id',
        'action',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
