<?php

declare(strict_types=1);

namespace App\Models\Rbac;

use App\Models\Corporation\Corporation;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Custom Role Model extending Spatie's base Role.
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $corporation_id
 * @property string $name
 * @property string $guard_name
 * @property string|null $description
 * @property bool $is_system_role
 * @property int $sort_order
 */
class Role extends SpatieRole
{
    use HasUuid;

    protected $fillable = [
        'name',
        'guard_name',
        'corporation_id',
        'description',
        'is_system_role',
        'sort_order',
    ];

    protected $casts = [
        'is_system_role' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * The corporation this role belongs to. NULL means it's a global/platform role.
     */
    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class, 'corporation_id');
    }
}
