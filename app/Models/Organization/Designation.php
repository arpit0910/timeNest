<?php

declare(strict_types=1);

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Designation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'organization_id',
        'sub_department_id',
        'name',
        'slug',
        'description',
        'level',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level'     => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Designation $model): void {
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

    public function subDepartment(): BelongsTo
    {
        return $this->belongsTo(SubDepartment::class);
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

    public function scopeByLevel($query, int $level): void
    {
        $query->where('level', $level);
    }
}
