<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Models\Auth\User;
use App\Models\Corporation\Branch;
use App\Models\Corporation\Corporation;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CorporationHoliday model — branch-specific or corporation-wide holidays.
 */
class CorporationHoliday extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'corporation_holidays';

    protected $fillable = [
        'corporation_id',
        'branch_id',
        'name',
        'holiday_date',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'holiday_date' => 'date:Y-m-d',
            'is_active' => 'boolean',
            'created_by' => 'integer',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->whereNull('deleted_at');
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->where('holiday_date', now()->toDateString());
    }
}
