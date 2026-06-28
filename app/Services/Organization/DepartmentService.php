<?php

declare(strict_types=1);

namespace App\Services\Organization;

use App\Models\Organization\Organization;
use App\Models\Organization\Department;
use App\Traits\HasAuditLog;
use Illuminate\Support\Facades\DB;

/**
 * Handles Department lifecycle within an Organization.
 */
class DepartmentService
{
    use HasAuditLog;

    /**
     * Create a new department.
     */
    public function createDepartment(Organization $organization, array $data): Department
    {
        app()->instance('current.organization', $organization);

        $branchId = null;
        if (!empty($data['branch_uuid'])) {
            $branchId = \App\Models\Organization\Branch::where('uuid', $data['branch_uuid'])->value('id');
        }

        $headUserId = null;
        if (!empty($data['head_user_uuid'])) {
            $headUserId = \App\Models\Auth\User::where('uuid', $data['head_user_uuid'])->value('id');
        }

        $dept = Department::create([
            'organization_id' => $organization->id,
            'branch_id' => $branchId ?? $data['branch_id'] ?? null,
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'head_user_id' => $headUserId ?? $data['head_user_id'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        $this->logAction('department.created', $dept, [], $dept->toArray());

        return $dept;
    }

    /**
     * Update an existing department.
     */
    public function updateDepartment(Department $dept, array $data): Department
    {
        app()->instance('current.organization', $dept->organization);

        $old = $dept->toArray();
        $dept->update($data);

        $this->logAction('department.updated', $dept, $old, $dept->toArray());

        return $dept;
    }

    /**
     * Delete (soft) a department.
     */
    public function deleteDepartment(Department $dept): void
    {
        app()->instance('current.organization', $dept->organization);

        // Note: In a real system, we'd need to handle sub-departments and employee assignments
        // before deleting.
        $dept->delete();
        $this->logAction('department.deleted', $dept);
    }

    public function findByUuid(string $uuid, int $organizationId): Department
    {
        return Department::with(['head', 'subDepartments'])
            ->where('organization_id', $organizationId)
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    /**
     * Assign or remove the head of a department.
     * Validates the user is a member of the same organization.
     */
    public function assignHead(Department $department, ?string $userUuid, int $organizationId): Department
    {
        return DB::transaction(function () use ($department, $userUuid, $organizationId): Department {
            $headUserId = null;

            if ($userUuid !== null) {
                $user = \App\Models\Auth\User::where('uuid', $userUuid)->firstOrFail();

                // Verify this user is actually a member of this organization
                $isMember = \App\Models\Organization\OrganizationMembership::where('organization_id', $organizationId)
                    ->where('user_id', $user->id)
                    ->exists();

                if (!$isMember) {
                    throw new \RuntimeException('The specified user is not a member of this organization.');
                }

                $headUserId = $user->id;
            }

            $department->update(['head_user_id' => $headUserId]);

            return $department->refresh()->load('head');
        });
    }
}
