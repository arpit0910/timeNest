<?php

declare(strict_types=1);

namespace App\Services\Organization;

use App\Actions\IssueJwtAction;
use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Exceptions\RoleNotAllowedException;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Rbac\Role;
use App\Traits\HasAuditLog;
use Illuminate\Support\Facades\DB;

/**
 * Handles employee onboarding, roles, and memberships within an Organization.
 */
class MembershipService
{
    use HasAuditLog;

    public function __construct(
        private readonly IssueJwtAction $issueJwtAction,
    ) {}

    /**
     * Add an existing user directly to an organization (no invite flow).
     */
    public function addMember(
        Organization $organization,
        User $user,
        Role $role,
        array $employeeData = [],
        ?int $invitedById = null
    ): OrganizationMembership {
        app()->instance('current.organization', $organization);
        $this->assertRoleAllowedForOrganization($organization, $role);

        return DB::transaction(function () use ($organization, $user, $role, $employeeData, $invitedById) {
            $membership = OrganizationMembership::create([
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'status' => MembershipStatus::Active,
                'invited_by' => $invitedById,
                'joined_at' => now(),
            ]);

            // Assign Spatie Role to the user within the context of this organization
            setPermissionsTeamId($organization->id);
            $user->assignRole($role);

            // Create base employee profile
            $profile = EmployeeProfile::create([
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'organization_membership_id' => $membership->id,
                'employee_code' => $employeeData['employee_code'] ?? null,
                'designation' => $employeeData['designation'] ?? null,
                'department_id' => $employeeData['department_id'] ?? null,
                'branch_id' => $employeeData['branch_id'] ?? null,
                'employment_type' => $employeeData['employment_type'] ?? 'full_time',
                'joining_date' => $employeeData['joining_date'] ?? now()->toDateString(),
                'reports_to' => $employeeData['reports_to'] ?? null,
                'is_active' => true,
            ]);

            $this->logAction('membership.added', $membership, [], [
                'user_id' => $user->id,
                'role_id' => $role->id,
                'employee_profile_id' => $profile->id,
            ]);

            return $membership;
        });
    }

    /**
     * Change a member's role.
     */
    public function changeRole(OrganizationMembership $membership, Role $newRole): OrganizationMembership
    {
        $organization = $membership->organization;
        app()->instance('current.organization', $organization);
        $this->assertRoleAllowedForOrganization($organization, $newRole);

        setPermissionsTeamId($organization->id);
        $user = $membership->user;

        // Sync Spatie roles for this team
        $user->syncRoles([$newRole]);

        $this->logAction('membership.role_changed', $membership, [], ['new_role' => $newRole->name]);

        return $membership;
    }

    /**
     * Update employee profile.
     */
    public function updateEmployeeProfile(EmployeeProfile $profile, array $data): EmployeeProfile
    {
        app()->instance('current.organization', $profile->organization);

        $old = $profile->toArray();
        $profile->update($data);

        $this->logAction('employee_profile.updated', $profile, $old, $profile->toArray());

        return $profile;
    }

    /**
     * Deactivate a member (removes access to org).
     */
    public function deactivateMember(OrganizationMembership $membership): void
    {
        app()->instance('current.organization', $membership->organization);

        DB::transaction(function () use ($membership) {
            $organization = $membership->organization;
            $membership->update(['status' => MembershipStatus::Suspended]);

            // Also deactivate employee profile
            $profile = EmployeeProfile::where('organization_membership_id', $membership->id)->first();
            if ($profile) {
                $profile->update(['is_active' => false]);
            }

            $user = $membership->user;
            $modelHasRoles = config('permission.table_names.model_has_roles');
            $teamColumn = config('permission.column_names.team_foreign_key', 'organization_id');
            $modelKey = config('permission.column_names.model_morph_key', 'model_id');

            DB::table($modelHasRoles)
                ->where($modelKey, $user->id)
                ->where('model_type', $user->getMorphClass())
                ->where($teamColumn, $organization->id)
                ->delete();

            $this->issueJwtAction->revokeOrganizationRefreshTokens($user->id, $organization->id);

            $this->logAction('membership.deactivated', $membership);
        });
    }

    private function assertRoleAllowedForOrganization(Organization $organization, Role $role): void
    {
        if ($role->guard_name !== 'api') {
            throw new RoleNotAllowedException('Role guard is not valid for API access.');
        }

        if ($role->organization_id !== null && (int) $role->organization_id !== $organization->id) {
            throw new RoleNotAllowedException('Role belongs to a different organization.');
        }

        if ($role->organization_id === null) {
            $systemRole = SystemRole::tryFrom($role->name);

            if (! $systemRole?->isOrganizationRole()) {
                throw new RoleNotAllowedException('Platform roles cannot be assigned to organization members.');
            }
        }
    }
}
