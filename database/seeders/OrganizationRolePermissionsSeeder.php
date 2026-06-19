<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;

/**
 * Seeds permissions for organization-scoped roles.
 *
 * This seeder runs AFTER DemoOrganizationSeeder to assign permissions
 * to roles within each organization context.
 *
 * Uses the same permission map as PlatformRolePermissionsSeeder,
 * but applies it to organization-scoped roles.
 */
class OrganizationRolePermissionsSeeder extends Seeder
{
    /**
     * Role → permission mapping (same as PlatformRolePermissionsSeeder).
     *
     * @return array<SystemRole, SystemPermission[]|null>
     */
    private function rolePermissionMap(): array
    {
        return [
            // Organization roles only
            SystemRole::OrganizationOwner->value => null, // ALL permissions
            SystemRole::OrganizationSuperAdmin->value => null, // ALL permissions
            SystemRole::OrganizationAdmin->value => [
                SystemPermission::UsersView,
                SystemPermission::UsersInvite,
                SystemPermission::UsersEdit,
                SystemPermission::UsersDelete,
                SystemPermission::UsersManage,
                SystemPermission::UsersExport,
                SystemPermission::InvitationsView,
                SystemPermission::InvitationsCreate,
                SystemPermission::InvitationsRevoke,
                SystemPermission::InvitationsResend,
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceCreate,
                SystemPermission::AttendanceEdit,
                SystemPermission::AttendanceDelete,
                SystemPermission::AttendanceApprove,
                SystemPermission::AttendanceExport,
                SystemPermission::AttendanceImport,
                SystemPermission::ReportsView,
                SystemPermission::ReportsExport,
                SystemPermission::BranchesView,
                SystemPermission::BranchesCreate,
                SystemPermission::BranchesEdit,
                SystemPermission::BranchesDelete,
                SystemPermission::BranchesManage,
                SystemPermission::DepartmentsView,
                SystemPermission::DepartmentsCreate,
                SystemPermission::DepartmentsEdit,
                SystemPermission::DepartmentsDelete,
                SystemPermission::DepartmentsManage,
                SystemPermission::SettingsManage,
                SystemPermission::WorklogView,
                SystemPermission::WorklogCreate,
                SystemPermission::WorklogApprove,
                SystemPermission::WorklogApproveAny,
                SystemPermission::LeavesApproveAny,
                SystemPermission::AttendanceApproveAny,
                SystemPermission::AttendanceAdjustmentsView,
                SystemPermission::AttendancePolicyView,
                SystemPermission::AttendancePolicyManage,
                SystemPermission::LeavePolicyView,
                SystemPermission::LeavePolicyManage,
                SystemPermission::WorklogPolicyView,
                SystemPermission::WorklogPolicyManage,
                SystemPermission::AttendanceEscalationsView,
                SystemPermission::AttendanceEscalationsResolve,
            ],
            SystemRole::HrManager->value => [
                SystemPermission::UsersView,
                SystemPermission::UsersInvite,
                SystemPermission::InvitationsView,
                SystemPermission::InvitationsCreate,
                SystemPermission::InvitationsResend,
                SystemPermission::HrmsView,
                SystemPermission::HrmsCreate,
                SystemPermission::HrmsEdit,
                SystemPermission::HrmsDelete,
                SystemPermission::HrmsExport,
                SystemPermission::LeavesView,
                SystemPermission::LeavesCreate,
                SystemPermission::LeavesEdit,
                SystemPermission::LeavesDelete,
                SystemPermission::LeavesApprove,
                SystemPermission::LeavesExport,
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceCreate,
                SystemPermission::AttendanceEdit,
                SystemPermission::AttendanceApprove,
                SystemPermission::AttendanceExport,
                SystemPermission::DepartmentsView,
                SystemPermission::WorklogView,
                SystemPermission::WorklogCreate,
                SystemPermission::WorklogApprove,
                SystemPermission::WorklogApproveAny,
                SystemPermission::LeavesApproveAny,
                SystemPermission::AttendanceApproveAny,
                SystemPermission::AttendanceAdjustmentsView,
                SystemPermission::AttendancePolicyView,
                SystemPermission::LeavePolicyView,
                SystemPermission::WorklogPolicyView,
                SystemPermission::AttendanceEscalationsView,
                SystemPermission::AttendanceEscalationsResolve,
            ],
            SystemRole::Manager->value => [
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceApprove,
                SystemPermission::LeavesView,
                SystemPermission::LeavesApprove,
                SystemPermission::ReportsView,
                SystemPermission::UsersView,
                SystemPermission::LeavesCreate,
                SystemPermission::WorklogView,
                SystemPermission::WorklogCreate,
                SystemPermission::WorklogApprove,
                SystemPermission::AttendanceAdjustmentsView,
                SystemPermission::AttendanceEscalationsView,
                SystemPermission::AttendanceEscalationsResolve,
            ],
            SystemRole::Supervisor->value => [
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceApprove,
                SystemPermission::AttendanceCreate,
                SystemPermission::LeavesCreate,
                SystemPermission::WorklogView,
                SystemPermission::WorklogCreate,
                SystemPermission::AttendanceAdjustmentsView,
                SystemPermission::AttendanceEscalationsView,
            ],
            SystemRole::Employee->value => [
                SystemPermission::AttendanceView,
                SystemPermission::LeavesView,
                SystemPermission::LeavesCreate,
                SystemPermission::AttendanceCreate,
                SystemPermission::WorklogView,
                SystemPermission::WorklogCreate,
                SystemPermission::AttendanceAdjustmentsView,
                SystemPermission::AttendanceAdjustmentsCreate,
            ],
            SystemRole::Contractor->value => [
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceCreate,
                SystemPermission::WorklogView,
                SystemPermission::WorklogCreate,
                SystemPermission::AttendanceAdjustmentsView,
                SystemPermission::AttendanceAdjustmentsCreate,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all organizations
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            $this->seedPermissionsForOrganization($organization);
        }
    }

    /**
     * Seed permissions for a specific organization.
     */
    private function seedPermissionsForOrganization(Organization $organization): void
    {
        $map = $this->rolePermissionMap();
        $totalAssignments = 0;

        foreach ($map as $roleName => $permissions) {
            // Find the organization-scoped role
            $role = Role::where('name', $roleName)
                ->where('organization_id', $organization->id)
                ->first();

            if (! $role) {
                continue;
            }

            if ($permissions === null) {
                // Wildcard: assign ALL permissions for this guard
                $perms = Permission::where('guard_name', $role->guard_name)->get();
            } else {
                // Map enum cases to permission name strings
                $permissionNames = array_map(fn (SystemPermission $p) => $p->value, $permissions);
                $perms = Permission::whereIn('name', $permissionNames)
                    ->where('guard_name', $role->guard_name)
                    ->get();
            }

            $role->syncPermissions($perms);
            $totalAssignments += $perms->count();

            $this->command->info("Synced {$perms->count()} permissions to role: {$role->name} in organization: {$organization->legal_name}");
        }

        $this->command->info("Total: Seeded {$totalAssignments} role-permission assignments for organization: {$organization->legal_name}");
    }
}
