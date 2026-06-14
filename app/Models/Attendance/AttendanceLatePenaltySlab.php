<?php

declare(strict_types=1);

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AttendanceLatePenaltySlab extends Model
{
    use HasFactory;

    protected $table = 'attendance_late_penalty_slabs';

    protected $fillable = [
        'attendance_policy_id',
        'late_count_threshold',
        'deduction_percentage',
    ];

    protected $casts = [
        'deduction_percentage' => 'decimal:2',
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

    public function policy(): BelongsTo
    {
        return $this->belongsTo(AttendancePolicy::class, 'attendance_policy_id');
    }
}
