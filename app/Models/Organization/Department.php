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
 * Supports hierarchy via self-referential parent_department_id.
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
        'organization_id', 'branch_id', 'parent_department_id',
        'name', 'code', 'head_user_id', 'is_active',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_department_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_department_id');
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_department_id');
    }
}
