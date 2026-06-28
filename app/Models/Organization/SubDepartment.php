<?php

declare(strict_types=1);

namespace App\Models\Organization;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubDepartment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'organization_id',
        'department_id',
        'name',
        'slug',
        'description',
        'head_user_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (SubDepartment $model): void {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    public function designations(): HasMany
    {
        return $this->hasMany(Designation::class);
    }

    public function activeDesignations(): HasMany
    {
        return $this->hasMany(Designation::class)->where('is_active', true);
    }

    public function scopeActive($query): void
    {
        $query->where('is_active', true);
    }

    public function scopeGlobal($query): void
    {
        $query->whereNull('organization_id');
    }

    public function scopeForOrganization($query, int $organizationId): void
    {
        $query->where(function ($q) use ($organizationId) {
            $q->whereNull('organization_id')
              ->orWhere('organization_id', $organizationId);
        });
    }
}
