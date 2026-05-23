<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;

/**
 * Maps permissions to system roles using Spatie Laravel Permission.
 *
 * Permission assignment per role as defined in the master architecture.
 * All references use SystemRole and SystemPermission enums — zero hardcoded strings.
 */
class PlatformRolePermissionsSeeder extends Seeder
{
    /**
     * Role → permission mapping.
     * Uses enum references exclusively.
     * null = all permissions (wildcard).
     *
     * @return array<SystemRole, SystemPermission[]|null>
     */
    private function rolePermissionMap(): array
    {
        return [
            // Platform roles
            SystemRole::AppOwner->value => null, // ALL permissions
            SystemRole::AppSuperAdmin->value => null, // ALL permissions
            SystemRole::AppAdmin->value => [
                SystemPermission::CorporationsManage,
                SystemPermission::UsersView,
                SystemPermission::UsersEdit,
                SystemPermission::UsersManage,
                SystemPermission::ReportsView,
                SystemPermission::AttendanceView,
            ],
            SystemRole::SupportAgent->value => [
                SystemPermission::UsersView,
                SystemPermission::ReportsView,
            ],
            SystemRole::Auditor->value => [
                SystemPermission::AttendanceView,
                SystemPermission::AttendanceExport,
                SystemPermission::UsersView,
                SystemPermission::UsersExport,
                SystemPermission::PayrollView,
                SystemPermission::PayrollExport,
                SystemPermission::HrmsView,
                SystemPermission::HrmsExport,
                SystemPermission::LeavesView,
                SystemPermission::LeavesExport,
                SystemPermission::BranchesView,
                SystemPermission::DepartmentsView,
                SystemPermission::ReportsView,
                SystemPermission::ReportsExport,
            ],

            // Corporation roles
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
        $allRoles = SystemRole::cases();
        $totalAssignments = 0;

        foreach ($allRoles as $systemRole) {
            $role = Role::where('name', $systemRole->value)
                ->where('guard_name', 'api')
                ->whereNull('corporation_id')
                ->first();

            if (! $role) {
                $this->command->warn("System role '{$systemRole->value}' not found in database. Skipping.");

                continue;
            }

            $map = $this->rolePermissionMap();
            if (! array_key_exists($systemRole->value, $map)) {
                continue;
            }

            $mapping = $map[$systemRole->value];

            if ($mapping === 'skip') {
                continue;
            }

            if ($mapping === null) {
                // Wildcard: assign ALL permissions for this guard
                $permissions = Permission::where('guard_name', $role->guard_name)->get();
            } else {
                // Map enum cases to permission name strings
                $permissionNames = array_map(fn (SystemPermission $p) => $p->value, $mapping);
                $permissions = Permission::whereIn('name', $permissionNames)
                    ->where('guard_name', $role->guard_name)
                    ->get();
            }

            $role->syncPermissions($permissions);
            $totalAssignments += $permissions->count();

            $this->command->info("Synced {$permissions->count()} permissions to role: {$role->name}");
        }

        $this->command->info("Total: Seeded {$totalAssignments} role-permission assignments via Spatie.");
    }
}
