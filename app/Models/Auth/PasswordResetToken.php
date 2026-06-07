<?php

declare(strict_types=1);

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'used_at',
        'created_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, PasswordResetToken>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
