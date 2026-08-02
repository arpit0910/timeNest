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
            $modelHasRolesTable = config('permission.table_names.model_has_roles');

            $fallbackRoleId = DB::table($rolesTable)
                ->where('name', 'app_super_admin')
                ->where('guard_name', 'api')
                ->whereNull('organization_id')
                ->value('id');

            // if ($fallbackRoleId === null) {
            //     throw new RuntimeException('The app_super_admin role must exist before retiring director roles.');
            // }

            $retiredRoleIds = DB::table($rolesTable)
                ->whereIn('name', ['director', 'app_director'])
                ->pluck('id');

            if ($retiredRoleIds->isNotEmpty()) {
                DB::table($modelHasRolesTable)
                    ->whereIn('role_id', $retiredRoleIds)
                    ->update(['role_id' => $fallbackRoleId]);

                DB::table($rolesTable)->whereIn('id', $retiredRoleIds)->delete();
            }
        });
    }

    public function down(): void
    {
        // Role retirement is intentionally irreversible: assignments have been migrated.
    }
};
