<?php

declare(strict_types=1);

namespace App\Models\Organization;

use App\Models\Geo\Country;
use App\Models\Geo\State;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Branch model — organization offices/locations.
 *
 * @property int $id
 * @property string $uuid
 * @property int $organization_id
 * @property string $name
 * @property bool $is_headquarters
 * @property bool $is_active
 */
class Branch extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'organization_id', 'name', 'code', 'is_headquarters',
        'phone', 'email',
        'address_line_1', 'address_line_2', 'city', 'postal_code',
        'state_id', 'country_id',
        'latitude', 'longitude', 'geo_fence_radius',
        'timezone', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_headquarters' => 'boolean',
            'is_active' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'geo_fence_radius' => 'integer',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHeadquarters($query)
    {
        return $query->where('is_headquarters', true);
    }
}
