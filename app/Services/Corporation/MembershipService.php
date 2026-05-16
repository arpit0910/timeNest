<?php

declare(strict_types=1);

namespace App\Services\Corporation;

use App\Enums\MembershipStatus;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Rbac\Role;
use App\Traits\HasAuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Handles employee onboarding, roles, and memberships within a Corporation.
 */
class MembershipService
{
    use HasAuditLog;

    /**
     * Add an existing user directly to a corporation (no invite flow).
     *
     * @param Corporation $corp
     * @param User $user
     * @param Role $role
     * @param array $employeeData
     * @param int|null $invitedById
     * @return CorpMembership
     */
    public function addMember(
        Corporation $corp,
        User $user,
        Role $role,
        array $employeeData = [],
        ?int $invitedById = null
    ): CorpMembership {
        app()->instance('current.corporation', $corp);

        return DB::transaction(function () use ($corp, $user, $role, $employeeData, $invitedById) {
            $membership = CorpMembership::create([
                'user_id'        => $user->id,
                'corporation_id' => $corp->id,
                'role_id'        => $role->id,
                'status'         => MembershipStatus::Active,
                'invited_by'     => $invitedById,
                'joined_at'      => now(),
            ]);

            // Create base employee profile
            $profile = EmployeeProfile::create([
                'user_id'            => $user->id,
                'corporation_id'     => $corp->id,
                'corp_membership_id' => $membership->id,
                'employee_code'      => $employeeData['employee_code'] ?? null,
                'designation'        => $employeeData['designation'] ?? null,
                'department_id'      => $employeeData['department_id'] ?? null,
                'branch_id'          => $employeeData['branch_id'] ?? null,
                'employment_type'    => $employeeData['employment_type'] ?? 'full_time',
                'joining_date'       => $employeeData['joining_date'] ?? now()->toDateString(),
                'reports_to'         => $employeeData['reports_to'] ?? null,
                'is_active'          => true,
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
     *
     * @param CorpMembership $membership
     * @param Role $newRole
     * @return CorpMembership
     */
    public function changeRole(CorpMembership $membership, Role $newRole): CorpMembership
    {
        app()->instance('current.corporation', $membership->corporation);

        $old = $membership->toArray();
        $membership->update(['role_id' => $newRole->id]);

        $this->logAction('membership.role_changed', $membership, $old, $membership->toArray());

        // In a real system, you'd invalidate tokens here for this user/corp combo.
        return $membership;
    }

    /**
     * Update employee profile.
     *
     * @param EmployeeProfile $profile
     * @param array $data
     * @return EmployeeProfile
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
     *
     * @param CorpMembership $membership
     * @return void
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
            
            // Note: Actual token revocation should happen at the controller/listener level
            $this->logAction('membership.deactivated', $membership);
        });
    }
}
