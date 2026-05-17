<?php

declare(strict_types=1);

namespace App\Models\Membership;

use App\Enums\EmploymentType;
use App\Models\Auth\User;
use App\Models\Corporation\Branch;
use App\Models\Corporation\Corporation;
use App\Models\Corporation\Department;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * EmployeeProfile — corporation-scoped employment data.
 *
 * Separate from User (global identity). One user can have multiple
 * employee profiles across different corporations.
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $corporation_id
 * @property int $corp_membership_id
 * @property EmploymentType|null $employment_type
 * @property bool $is_active
 */
class EmployeeProfile extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'employee_profiles';

    protected $fillable = [
        'user_id', 'corporation_id', 'corp_membership_id',
        'employee_code', 'designation', 'department_id', 'branch_id', 'reports_to',
        'employment_type', 'joining_date', 'confirmation_date', 'exit_date', 'exit_reason',
        'work_location', 'bio', 'linkedin_url',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relation',
        'is_active', 'documents',
    ];

    protected function casts(): array
    {
        return [
            'employment_type' => EmploymentType::class,
            'joining_date' => 'date',
            'confirmation_date' => 'date',
            'exit_date' => 'date',
            'is_active' => 'boolean',
            'documents' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(CorpMembership::class, 'corp_membership_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function reportsTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reports_to');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
