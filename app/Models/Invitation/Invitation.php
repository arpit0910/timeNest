<?php

declare(strict_types=1);

namespace App\Models\Invitation;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Rbac\Role;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Invitation model — organization user invitations.
 *
 * Token is stored as SHA-256 hash. Raw token is sent to user only once.
 *
 * @property int $id
 * @property string $uuid
 * @property int $organization_id
 * @property string $email
 * @property string $token
 * @property Carbon $expires_at
 * @property Carbon|null $accepted_at
 * @property Carbon|null $revoked_at
 */
class Invitation extends Model
{
    use HasUuid;

    protected $table = 'organization_invitations';

    protected $fillable = [
        'organization_id', 'email', 'role_id', 'invited_by_user_id',
        'token', 'status', 'expires_at', 'accepted_at', 'revoked_at',
        'revoked_by', 'resend_count', 'last_resent_at', 'metadata',
    ];

    protected $hidden = ['token'];

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\InvitationStatusEnum::class,
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'revoked_at' => 'datetime',
            'last_resent_at' => 'datetime',
            'resend_count' => 'integer',
            'metadata' => 'array',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by_user_id');
    }

    public function revokedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revoked_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', \App\Enums\InvitationStatusEnum::Pending);
    }

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\InvitationStatusEnum::Pending)
            ->where('expires_at', '>', now());
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isAccepted(): bool
    {
        return $this->status === \App\Enums\InvitationStatusEnum::Accepted;
    }

    public function isRevoked(): bool
    {
        return $this->status === \App\Enums\InvitationStatusEnum::Revoked;
    }

    public function isPending(): bool
    {
        return $this->status === \App\Enums\InvitationStatusEnum::Pending;
    }
}
