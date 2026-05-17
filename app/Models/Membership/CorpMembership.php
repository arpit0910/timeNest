<?php

declare(strict_types=1);

namespace App\Models\Membership;

use App\Enums\MembershipStatus;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CorpMembership — user ↔ corporation bridge.
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $corporation_id
 * @property int $role_id
 * @property MembershipStatus $status
 */
class CorpMembership extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'corp_memberships';

    protected $fillable = [
        'user_id', 'corporation_id', 'invited_by',
        'status', 'joined_at', 'left_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => MembershipStatus::class,
            'joined_at' => 'datetime',
            'left_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function employeeProfile(): HasOne
    {
        return $this->hasOne(EmployeeProfile::class, 'corp_membership_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', MembershipStatus::Active);
    }

    public function scopePending($query)
    {
        return $query->where('status', MembershipStatus::Pending);
    }

    public function scopeForCorporation($query, int $corpId)
    {
        return $query->where('corporation_id', $corpId);
    }
}
