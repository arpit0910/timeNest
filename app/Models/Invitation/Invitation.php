<?php

declare(strict_types=1);

namespace App\Models\Invitation;

use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Rbac\Role;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Invitation model — corporation user invitations.
 *
 * Token is stored as SHA-256 hash. Raw token is sent to user only once.
 *
 * @property int $id
 * @property string $uuid
 * @property int $corporation_id
 * @property string $email
 * @property string $token
 * @property Carbon $expires_at
 * @property Carbon|null $accepted_at
 * @property Carbon|null $revoked_at
 */
class Invitation extends Model
{
    use HasUuid;

    protected $table = 'invitations';

    protected $fillable = [
        'corporation_id', 'email', 'role_id', 'invited_by',
        'token', 'expires_at', 'accepted_at', 'revoked_at',
        'revoked_by', 'resend_count', 'last_resent_at',
    ];

    protected $hidden = ['token'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'revoked_at' => 'datetime',
            'last_resent_at' => 'datetime',
            'resend_count' => 'integer',
        ];
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function revokedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revoked_by');
    }

    public function scopePending($query)
    {
        return $query->whereNull('accepted_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now());
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isAccepted(): bool
    {
        return $this->accepted_at !== null;
    }

    public function isRevoked(): bool
    {
        return $this->revoked_at !== null;
    }
}
