<?php

declare(strict_types=1);

namespace App\Models\Rbac;

use App\Enums\AuthGuard;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Role model — system + corporation custom roles.
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $corporation_id
 * @property string $name
 * @property AuthGuard $guard
 * @property bool $is_system_role
 */
class Role extends Model
{
    use HasUuid;

    protected $table = 'roles';

    protected $fillable = [
        'corporation_id', 'name', 'guard', 'description',
        'is_system_role', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'guard'          => AuthGuard::class,
            'is_system_role' => 'boolean',
            'sort_order'     => 'integer',
        ];
    }

    public function corporation(): BelongsTo { return $this->belongsTo(Corporation::class); }
    public function memberships(): HasMany { return $this->hasMany(CorpMembership::class); }
    public function overrides(): HasMany { return $this->hasMany(CorpRolePermissionOverride::class); }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }

    public function scopeSystem($query) { return $query->where('is_system_role', true); }
    public function scopeCustom($query) { return $query->where('is_system_role', false); }
    public function scopeByGuard($query, AuthGuard $guard) { return $query->where('guard', $guard); }
    public function scopeCorporationRoles($query) { return $query->where('guard', AuthGuard::Corp); }
    public function scopePlatformRoles($query) { return $query->where('guard', AuthGuard::Platform); }

    /**
     * Get system roles available for a corporation (global system roles + corp custom roles).
     */
    public function scopeAvailableForCorporation($query, int $corpId)
    {
        return $query->where('guard', AuthGuard::Corp)
            ->where(function ($q) use ($corpId) {
                $q->whereNull('corporation_id')
                  ->orWhere('corporation_id', $corpId);
            });
    }
}
