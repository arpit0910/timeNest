<?php

declare(strict_types=1);

namespace App\Services\Organization;

use App\Models\Membership\EmployeeProfile;
use App\Models\Organization\OrganizationMembership;
use App\Models\Organization\Designation;
use Illuminate\Support\Facades\DB;

class MemberHierarchyService
{
    /**
     * Assign or remove a designation from a member.
     *
     * Updates both organization_members and employee_profiles atomically.
     * The designation must be visible to this organization (global or org-specific).
     * Passing designation_uuid = null removes the designation.
     */
    public function assignDesignation(
        string $memberUuid,
        ?string $designationUuid,
        int $organizationId
    ): OrganizationMembership {
        return DB::transaction(function () use ($memberUuid, $designationUuid, $organizationId): OrganizationMembership {

            // Resolve the member within this org
            $member = OrganizationMembership::where('uuid', $memberUuid)
                ->where('organization_id', $organizationId)
                ->firstOrFail();

            $designationId = null;

            if ($designationUuid !== null) {
                // Designation must be visible to this org (global or org-specific)
                $designation = Designation::where('uuid', $designationUuid)
                    ->where(function ($q) use ($organizationId) {
                        $q->whereNull('organization_id')
                          ->orWhere('organization_id', $organizationId);
                    })
                    ->firstOrFail();

                $designationId = $designation->id;
            }

            // Update organization_members
            $member->update(['designation_id' => $designationId]);

            // Update employee_profiles atomically
            EmployeeProfile::where('user_id', $member->user_id)
                ->where('organization_id', $organizationId)
                ->update(['designation_id' => $designationId]);

            return $member->refresh()->load([
                'designation.subDepartment.department',
            ]);
        });
    }

    /**
     * Resolve the full hierarchy context for a member.
     *
     * Returns designation → sub-department → department → heads.
     * If the member has no designation assigned, returns nulls gracefully.
     */
    public function resolveHierarchy(string $memberUuid, int $organizationId): array
    {
        $member = OrganizationMembership::where('uuid', $memberUuid)
            ->where('organization_id', $organizationId)
            ->with([
                'designation.subDepartment.department.head',
                'designation.subDepartment.head',
                'user',
            ])
            ->firstOrFail();

        $designation   = $member->designation;
        $subDepartment = $designation?->subDepartment;
        $department    = $subDepartment?->department;

        return [
            'member' => [
                'uuid' => $member->uuid,
                'name' => $member->user->name,
                'role' => $member->role,
            ],
            'designation' => $designation ? [
                'uuid'        => $designation->uuid,
                'name'        => $designation->name,
                'level'       => $designation->level,
                'level_label' => match($designation->level) {
                    1 => 'Junior',
                    2 => 'Mid',
                    3 => 'Senior',
                    4 => 'Lead',
                    5 => 'Principal / Head',
                    default => 'Unknown',
                },
            ] : null,
            'sub_department' => $subDepartment ? [
                'uuid' => $subDepartment->uuid,
                'name' => $subDepartment->name,
                'head' => $subDepartment->head ? [
                    'uuid' => $subDepartment->head->uuid,
                    'name' => $subDepartment->head->name,
                ] : null,
            ] : null,
            'department' => $department ? [
                'uuid' => $department->uuid,
                'name' => $department->name,
                'head' => $department->head ? [
                    'uuid' => $department->head->uuid,
                    'name' => $department->head->name,
                ] : null,
            ] : null,
        ];
    }
}
