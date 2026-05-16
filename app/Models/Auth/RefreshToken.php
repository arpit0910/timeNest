<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * RefreshToken model — hashed refresh token storage for revocation support.
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $token_hash
 * @property string $guard
 * @property int|null $corporation_id
 * @property \Carbon\Carbon $expires_at
 * @property \Carbon\Carbon|null $revoked_at
 */
class RefreshToken extends Model
{
    use HasUuid;

    protected $table = 'refresh_tokens';

    protected $fillable = [
        'user_id',
        'token_hash',
        'guard',
        'corporation_id',
        'ip_address',
        'user_agent',
        'expires_at',
        'revoked_at',
    ];

    protected $hidden = [
        'token_hash',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: only valid (not expired, not revoked) tokens.
     */
    public function scopeValid($query)
    {
        return $query->whereNull('revoked_at')->where('expires_at', '>', now());
    }
}
