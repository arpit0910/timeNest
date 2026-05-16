<?php

declare(strict_types=1);

namespace App\Models\Geo;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * State model — province/region under a country.
 *
 * @property int $id
 * @property string $uuid
 * @property int $country_id
 * @property string $name
 * @property string|null $state_code
 */
class State extends Model
{
    use HasUuid;

    protected $table = 'states';

    protected $fillable = [
        'country_id',
        'name',
        'state_code',
    ];

    /**
     * @return BelongsTo<Country, self>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
