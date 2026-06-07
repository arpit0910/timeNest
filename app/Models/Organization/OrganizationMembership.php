<?php

declare(strict_types=1);

namespace App\Models\Organization;

use App\Enums\MembershipStatus;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Membership\EmployeeProfile;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * OrganizationMembership — user ↔ organization bridge.
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $organization_id
 * @property int $role_id
 * @property MembershipStatus $status
 */
class OrganizationMembership extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'organization_memberships';

    protected $fillable = [
        'user_id', 'organization_id', 'invited_by',
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

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function employeeProfile(): HasOne
    {
        return $this->hasOne(EmployeeProfile::class, 'organization_membership_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', MembershipStatus::Active);
    }

    public function scopePending($query)
    {
        return $query->where('status', MembershipStatus::Pending);
    }

    public function scopeForOrganization($query, int $orgId)
    {
        return $query->where('organization_id', $orgId);
    }
}
