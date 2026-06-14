<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveBalance extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'leave_balances';

    protected $fillable = [
        'organization_id',
        'user_id',
        'leave_type_id',
        'year',
        'allocated_days',
        'carry_forward_days',
        'used_days',
        'pending_days',
        'remaining_days',
    ];

    protected function casts(): array
    {
        return [
            'allocated_days' => 'decimal:2',
            'carry_forward_days' => 'decimal:2',
            'used_days' => 'decimal:2',
            'pending_days' => 'decimal:2',
            'remaining_days' => 'decimal:2',
            'year' => 'integer',
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

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }
}
