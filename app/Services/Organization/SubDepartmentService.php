<?php

declare(strict_types=1);

namespace App\Services\Organization;

use App\Models\Organization\Department;
use App\Models\Organization\SubDepartment;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubDepartmentService
{
    /**
     * List sub-departments visible to this organization.
     * Returns global records + org-specific records combined.
     */
    public function list(int $organizationId, ?string $departmentUuid, int $perPage = 20): LengthAwarePaginator
    {
        return SubDepartment::with(['department', 'head', 'designations'])
            ->forOrganization($organizationId)
            ->when($departmentUuid, function ($query) use ($departmentUuid) {
                $query->whereHas('department', fn($q) => $q->where('uuid', $departmentUuid));
            })
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Find a single sub-department by UUID, scoped to this org.
     */
    public function findByUuid(string $uuid, int $organizationId): SubDepartment
    {
        return SubDepartment::with(['department', 'head', 'designations.subDepartment'])
            ->forOrganization($organizationId)
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    /**
     * Create a new org-scoped sub-department.
     */
    public function create(array $data, ?int $organizationId): SubDepartment
    {
        // Org users cannot create global records
        if ($organizationId === null) {
            throw new \InvalidArgumentException('organization_id is required for creating sub-departments.');
        }

        return DB::transaction(function () use ($data, $organizationId): SubDepartment {
            $department = Department::where('uuid', $data['department_uuid'])->firstOrFail();

            $headUserId = null;
            if (!empty($data['head_user_uuid'])) {
                $headUserId = User::where('uuid', $data['head_user_uuid'])->firstOrFail()->id;
            }

            return SubDepartment::create([
                'organization_id' => $organizationId,
                'department_id'   => $department->id,
                'name'            => $data['name'],
                'slug'            => Str::slug($data['name']),
                'description'     => $data['description'] ?? null,
                'head_user_id'    => $headUserId,
                'is_active'       => $data['is_active'] ?? true,
            ]);
        });
    }

    /**
     * Update an existing sub-department.
     * Only org-owned sub-departments can be updated (not global ones).
     */
    public function update(SubDepartment $subDepartment, array $data, int $organizationId): SubDepartment
    {
        // Global sub-departments cannot be modified by org admins
        if ($subDepartment->organization_id === null) {
            throw new \RuntimeException('Global sub-departments cannot be modified by organizations.');
        }

        return DB::transaction(function () use ($subDepartment, $data, $organizationId): SubDepartment {
            $headUserId = $subDepartment->head_user_id;
            if (array_key_exists('head_user_uuid', $data)) {
                $headUserId = $data['head_user_uuid']
                    ? User::where('uuid', $data['head_user_uuid'])->firstOrFail()->id
                    : null;
            }

            $subDepartment->update([
                'name'         => $data['name'] ?? $subDepartment->name,
                'slug'         => isset($data['name']) ? Str::slug($data['name']) : $subDepartment->slug,
                'description'  => $data['description'] ?? $subDepartment->description,
                'head_user_id' => $headUserId,
                'is_active'    => $data['is_active'] ?? $subDepartment->is_active,
            ]);

            return $subDepartment->refresh();
        });
    }

    /**
     * Soft-delete a sub-department.
     * Only org-owned sub-departments can be deleted.
     */
    public function delete(SubDepartment $subDepartment): void
    {
        if ($subDepartment->organization_id === null) {
            throw new \RuntimeException('Global sub-departments cannot be deleted by organizations.');
        }

        DB::transaction(function () use ($subDepartment): void {
            $subDepartment->delete();
        });
    }

    /**
     * Assign or remove the head of a sub-department.
     * Validates the user is a member of the same organization.
     * Global sub-departments can only have heads assigned by platform admins —
     * org admins can assign heads to their own sub-departments only.
     */
    public function assignHead(SubDepartment $subDepartment, ?string $userUuid, int $organizationId): SubDepartment
    {
        if ($subDepartment->organization_id === null) {
            throw new \RuntimeException('Cannot assign a head to a global sub-department from an organization context.');
        }

        return DB::transaction(function () use ($subDepartment, $userUuid, $organizationId): SubDepartment {
            $headUserId = null;

            if ($userUuid !== null) {
                $user = \App\Models\Auth\User::where('uuid', $userUuid)->firstOrFail();

                $isMember = \App\Models\Organization\OrganizationMembership::where('organization_id', $organizationId)
                    ->where('user_id', $user->id)
                    ->exists();

                if (!$isMember) {
                    throw new \RuntimeException('The specified user is not a member of this organization.');
                }

                $headUserId = $user->id;
            }

            $subDepartment->update(['head_user_id' => $headUserId]);

            return $subDepartment->refresh()->load(['head', 'department']);
        });
    }
}
