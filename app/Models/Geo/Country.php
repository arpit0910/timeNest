<?php

declare(strict_types=1);

namespace App\Models\Geo;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Country model — foundation for geo-location data.
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $iso2
 * @property string $iso3
 * @property string $phone_code
 * @property string|null $currency_code
 * @property string|null $currency_symbol
 */
class Country extends Model
{
    use HasUuid;

    protected $table = 'countries';

    protected $fillable = [
        'name',
        'iso2',
        'iso3',
        'phone_code',
        'currency_code',
        'currency_symbol',
    ];

    /**
     * @return HasMany<State>
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
