<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Enums\OAuthProvider;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * OAuthAccount model — OAuth provider connections.
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property OAuthProvider $provider
 * @property string $provider_id
 * @property string|null $provider_email
 * @property string|null $provider_name
 * @property string|null $provider_avatar
 */
class OAuthAccount extends Model
{
    use HasUuid, HasFactory;

    protected $table = 'oauth_accounts';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'provider_email',
        'provider_name',
        'provider_avatar',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'provider' => OAuthProvider::class,
            'access_token' => 'encrypted',
            'refresh_token' => 'encrypted',
            'token_expires_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
