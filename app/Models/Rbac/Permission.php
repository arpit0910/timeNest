<?php

declare(strict_types=1);

namespace App\Models\Rbac;

use App\Traits\HasUuid;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Custom Permission Model extending Spatie's base Permission.
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $guard_name
 * @property string|null $module
 * @property string|null $action
 * @property string|null $description
 */
class Permission extends SpatiePermission
{
    use HasUuid;

    protected $fillable = [
        'name',
        'guard_name',
        'module',
        'action',
        'description',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
