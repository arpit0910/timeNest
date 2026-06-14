<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LeaveType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leave_types';

    protected $fillable = [
        'organization_id',
        'leave_policy_id',
        'name',
        'code',
        'color_hex',
        'is_paid',
        'is_system_type',
        'requires_document',
        'allow_half_day',
        'annual_allocation_days',
        'max_per_request_days',
        'min_per_request_days',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'is_system_type' => 'boolean',
        'requires_document' => 'boolean',
        'allow_half_day' => 'boolean',
        'is_active' => 'boolean',
        'annual_allocation_days' => 'decimal:2',
        'min_per_request_days' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(LeavePolicy::class, 'leave_policy_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
