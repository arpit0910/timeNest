<?php

declare(strict_types=1);

namespace App\Models\Organization;

use App\Models\Auth\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Department model — organizational units within an organization.
 *
 * @property int $id
 * @property string $uuid
 * @property int $organization_id
 * @property string $name
 * @property bool $is_active
 */
class Department extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'organization_id', 'branch_id',
        'name', 'code', 'slug', 'description', 'head_user_id', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Sub-departments that belong to this department.
     */
    public function subDepartments(): HasMany
    {
        return $this->hasMany(SubDepartment::class);
    }

    /**
     * Active sub-departments only.
     */
    public function activeSubDepartments(): HasMany
    {
        return $this->hasMany(SubDepartment::class)->where('is_active', true);
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    /**
     * Organization members scoped to this department via organization_memberships.department_id.
     */
    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMembership::class, 'department_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
