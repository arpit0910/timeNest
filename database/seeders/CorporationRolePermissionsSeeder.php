<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Corporation\Corporation;
use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;

/**
 * Seeds permissions for corporation-scoped roles.
 *
 * This seeder runs AFTER DemoCorporationSeeder to assign permissions
 * to roles within each corporation context.
 *
 * Uses the same permission map as PlatformRolePermissionsSeeder,
 * but applies it to corporation-scoped roles.
 */
class CorporationRolePermissionsSeeder extends Seeder
{
    /**
     * Role → permission mapping (same as PlatformRolePermissionsSeeder).
     *
     * @return array<SystemRole, SystemPermission[]|null>
     */
    private function rolePermissionMap(): array
    {
        return [
            // Corporation roles only
            SystemRole::CorpOwner->value => null, // ALL permissions
            SystemRole::CorpSuperAdmin->value => null, // ALL permissions
            SystemRole::CorpAdmin->value => [
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
            ],
            SystemRole::Manager->value => [
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceApprove,
                SystemPermission::LeavesView,
                SystemPermission::LeavesApprove,
                SystemPermission::ReportsView,
                SystemPermission::UsersView,
            ],
            SystemRole::Supervisor->value => [
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceApprove,
            ],
            SystemRole::Employee->value => [
                SystemPermission::AttendanceView,
                SystemPermission::LeavesView,
                SystemPermission::LeavesCreate,
            ],
            SystemRole::Contractor->value => [
                SystemPermission::AttendanceView,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all corporations
        $corporations = Corporation::all();

        foreach ($corporations as $corp) {
            $this->seedPermissionsForCorporation($corp);
        }
    }

    /**
     * Seed permissions for a specific corporation.
     */
    private function seedPermissionsForCorporation(Corporation $corp): void
    {
        $map = $this->rolePermissionMap();
        $totalAssignments = 0;

        foreach ($map as $roleName => $permissions) {
            // Find the corporation-scoped role
            $role = Role::where('name', $roleName)
                ->where('corporation_id', $corp->id)
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

            $this->command->info("Synced {$perms->count()} permissions to role: {$role->name} in corporation: {$corp->legal_name}");
        }

        $this->command->info("Total: Seeded {$totalAssignments} role-permission assignments for corporation: {$corp->legal_name}");
    }
}
