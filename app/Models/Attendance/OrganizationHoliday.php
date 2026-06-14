<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use App\Models\Auth\User;
use App\Models\Organization\Branch;
use App\Models\Organization\Organization;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * OrganizationHoliday model — branch-specific or organization-wide holidays.
 */
class OrganizationHoliday extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'organization_holidays';

    protected $fillable = [
        'organization_id',
        'branch_id',
        'name',
        'holiday_date',
        'is_recurring',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'holiday_date' => 'date:Y-m-d',
            'is_recurring' => 'boolean',
            'is_active' => 'boolean',
            'created_by' => 'integer',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
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
