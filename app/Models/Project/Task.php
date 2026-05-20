<?php

declare(strict_types=1);

namespace App\Models\Project;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'uuid',
        'milestone_id',
        'name',
        'estimated_minutes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_minutes' => 'integer',
        ];
    }

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class);
    }

    public function timeConsumptions(): HasMany
    {
        return $this->hasMany(TaskTimeConsumption::class);
    }

    public function getConsumedMinutesAttribute(): int
    {
        return (int) $this->timeConsumptions()->sum('consumed_minutes');
    }
}
