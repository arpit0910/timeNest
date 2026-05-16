<?php

declare(strict_types=1);

namespace App\Models\Membership;

use App\Models\Auth\User;
use App\Models\Rbac\Role;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * PlatformMembership — platform admin user roles.
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $role_id
 * @property string $status
 */
class PlatformMembership extends Model
{
    use HasUuid;

    protected $table = 'platform_memberships';

    protected $fillable = [
        'user_id', 'status', 'granted_by',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function grantedBy(): BelongsTo { return $this->belongsTo(User::class, 'granted_by'); }

    public function scopeActive($query) { return $query->where('status', 'active'); }
}
