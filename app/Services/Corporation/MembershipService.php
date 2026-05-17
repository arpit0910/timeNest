<?php

declare(strict_types=1);

namespace App\Services\Corporation;

use App\Actions\IssueJwtAction;
use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Exceptions\RoleNotAllowedException;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Rbac\Role;
use App\Traits\HasAuditLog;
use Illuminate\Support\Facades\DB;

/**
 * Handles employee onboarding, roles, and memberships within a Corporation.
 */
class MembershipService
{
    use HasAuditLog;

    public function __construct(
        private readonly IssueJwtAction $issueJwtAction,
    ) {}

    /**
     * Add an existing user directly to a corporation (no invite flow).
     */
    public function addMember(
        Corporation $corp,
        User $user,
        Role $role,
        array $employeeData = [],
        ?int $invitedById = null
    ): CorpMembership {
        app()->instance('current.corporation', $corp);
        $this->assertRoleAllowedForCorporation($corp, $role);

        return DB::transaction(function () use ($corp, $user, $role, $employeeData, $invitedById) {
            $membership = CorpMembership::create([
                'user_id' => $user->id,
                'corporation_id' => $corp->id,
                'status' => MembershipStatus::Active,
                'invited_by' => $invitedById,
                'joined_at' => now(),
            ]);

            // Assign Spatie Role to the user within the context of this corporation
            setPermissionsTeamId($corp->id);
            $user->assignRole($role);

            // Create base employee profile
            $profile = EmployeeProfile::create([
                'user_id' => $user->id,
                'corporation_id' => $corp->id,
                'corp_membership_id' => $membership->id,
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
    public function changeRole(CorpMembership $membership, Role $newRole): CorpMembership
    {
        $corp = $membership->corporation;
        app()->instance('current.corporation', $corp);
        $this->assertRoleAllowedForCorporation($corp, $newRole);

        setPermissionsTeamId($corp->id);
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
        app()->instance('current.corporation', $profile->corporation);

        $old = $profile->toArray();
        $profile->update($data);

        $this->logAction('employee_profile.updated', $profile, $old, $profile->toArray());

        return $profile;
    }

    /**
     * Deactivate a member (removes access to corp).
     */
    public function deactivateMember(CorpMembership $membership): void
    {
        app()->instance('current.corporation', $membership->corporation);

        DB::transaction(function () use ($membership) {
            $membership->update(['status' => MembershipStatus::Suspended]);

            // Also deactivate employee profile
            $profile = EmployeeProfile::where('corp_membership_id', $membership->id)->first();
            if ($profile) {
                $profile->update(['is_active' => false]);
            }

            $user = $membership->user;
            $corp = $membership->corporation;
            $modelHasRoles = config('permission.table_names.model_has_roles');
            $teamColumn = config('permission.column_names.team_foreign_key', 'corporation_id');
            $modelKey = config('permission.column_names.model_morph_key', 'model_id');

            DB::table($modelHasRoles)
                ->where($modelKey, $user->id)
                ->where('model_type', $user->getMorphClass())
                ->where($teamColumn, $corp->id)
                ->delete();

            $this->issueJwtAction->revokeCorpRefreshTokens($user->id, $corp->id);

            $this->logAction('membership.deactivated', $membership);
        });
    }

    private function assertRoleAllowedForCorporation(Corporation $corp, Role $role): void
    {
        if ($role->guard_name !== 'api') {
            throw new RoleNotAllowedException('Role guard is not valid for API access.');
        }

        if ($role->corporation_id !== null && (int) $role->corporation_id !== $corp->id) {
            throw new RoleNotAllowedException('Role belongs to a different corporation.');
        }

        if ($role->corporation_id === null) {
            $systemRole = SystemRole::tryFrom($role->name);

            if (! $systemRole?->isCorpRole()) {
                throw new RoleNotAllowedException('Platform roles cannot be assigned to corporation members.');
            }
        }
    }
}
