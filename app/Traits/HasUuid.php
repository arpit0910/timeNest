<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Provides UUID generation and route-model-binding by UUID.
 *
 * Every model in TimeNest uses integer `id` for internal FK references
 * and `uuid` for all external/API exposure. This trait ensures:
 * - UUID auto-generated on model creation
 * - Route model binding resolves by `uuid`
 * - A `scopeByUuid` local scope for manual lookups
 */
trait HasUuid
{
    /**
     * Boot the trait: auto-generate UUID on creating event.
     */
    public static function bootHasUuid(): void
    {
        static::creating(function (Model $model): void {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the route key name for route-model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Resolve route binding by UUID.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where($field ?? 'uuid', $value)->first();
    }

    /**
     * Scope: filter by UUID.
     */
    public function scopeByUuid(Builder $query, string $uuid): Builder
    {
        return $query->where('uuid', $uuid);
    }
}
