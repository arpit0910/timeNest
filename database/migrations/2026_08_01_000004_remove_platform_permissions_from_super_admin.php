<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            $rolesTable = config('permission.table_names.roles');
            $permissionsTable = config('permission.table_names.permissions');
            $rolePermissionsTable = config('permission.table_names.role_has_permissions');

            $roleIds = DB::table($rolesTable)
                ->where('name', 'super_admin')
                ->pluck('id');
            $platformPermissionIds = DB::table($permissionsTable)
                ->where('name', 'like', 'platform.%')
                ->pluck('id');

            if ($roleIds->isNotEmpty() && $platformPermissionIds->isNotEmpty()) {
                DB::table($rolePermissionsTable)
                    ->whereIn('role_id', $roleIds)
                    ->whereIn('permission_id', $platformPermissionIds)
                    ->delete();
            }
        });
    }

    public function down(): void
    {
        // Platform permissions are intentionally never restored to organization roles.
    }
};
