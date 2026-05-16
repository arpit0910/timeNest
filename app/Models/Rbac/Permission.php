<?php

declare(strict_types=1);

namespace App\Models\Rbac;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Permission model — dot-notation module.action permissions.
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $module
 * @property string $action
 * @property bool $is_active
 */
class Permission extends Model
{
    use HasUuid;

    protected $table = 'permissions';

    protected $fillable = [
        'name', 'module', 'action', 'description', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')->withTimestamps();
    }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeByModule($query, string $module) { return $query->where('module', $module); }
}
