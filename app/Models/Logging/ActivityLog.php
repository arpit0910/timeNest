<?php

declare(strict_types=1);

namespace App\Models\Logging;

use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ActivityLog — user activity stream (softer than audit).
 *
 * Tracks: login, logout, profile updates, corporation switches, etc.
 * Append-only: only created_at, no updated_at.
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property \Carbon\Carbon $created_at
 */
class ActivityLog extends Model
{
    use HasUuid;

    protected $table = 'activity_logs';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id', 'corporation_id', 'type',
        'description', 'ip_address', 'user_agent', 'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata'   => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function corporation(): BelongsTo { return $this->belongsTo(Corporation::class); }

    public function scopeForUser($query, int $userId) { return $query->where('user_id', $userId); }
    public function scopeByType($query, string $type) { return $query->where('type', $type); }
}
