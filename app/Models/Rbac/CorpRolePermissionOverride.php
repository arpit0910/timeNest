<?php

declare(strict_types=1);

namespace App\Models\Rbac;

use App\Enums\OverrideType;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CorpRolePermissionOverride — per-corporation permission customization.
 *
 * @property int $id
 * @property string $uuid
 * @property int $corporation_id
 * @property int $role_id
 * @property int $permission_id
 * @property OverrideType $type
 * @property int $created_by
 */
class CorpRolePermissionOverride extends Model
{
    use HasUuid;

    protected $table = 'corporation_role_permission_overrides';

    protected $fillable = [
        'corporation_id', 'role_id', 'permission_id', 'type', 'created_by',
    ];

    protected function casts(): array
    {
        return ['type' => OverrideType::class];
    }

    public function corporation(): BelongsTo { return $this->belongsTo(Corporation::class); }
    public function role(): BelongsTo { return $this->belongsTo(Role::class); }
    public function permission(): BelongsTo { return $this->belongsTo(Permission::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
}
