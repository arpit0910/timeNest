<?php

declare(strict_types=1);

namespace App\Models\Membership;

use App\Enums\EmploymentType;
use App\Models\Auth\User;
use App\Models\Organization\Branch;
use App\Models\Organization\Organization;
use App\Models\Organization\Department;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Organization\Designation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * EmployeeProfile — organization-scoped employment data.
 *
 * Separate from User (global identity). One user can have multiple
 * employee profiles across different organizations.
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $organization_id
 * @property int $organization_membership_id
 * @property EmploymentType|null $employment_type
 * @property bool $is_active
 */
class EmployeeProfile extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'employee_profiles';

    protected $fillable = [
        'user_id', 'organization_id', 'organization_membership_id',
        'employee_code', 'designation_id', 'department_id', 'branch_id', 'reports_to',
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

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(OrganizationMembership::class, 'organization_membership_id');
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

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
