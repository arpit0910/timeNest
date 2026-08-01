<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            DB::table(config('permission.table_names.roles'))
                ->where('name', 'freelance_team_owner')
                ->where('guard_name', 'api')
                ->update(['name' => 'freelance_super_admin']);
        });
    }

    public function down(): void
    {
        DB::transaction(function (): void {
            DB::table(config('permission.table_names.roles'))
                ->where('name', 'freelance_super_admin')
                ->where('guard_name', 'api')
                ->update(['name' => 'freelance_team_owner']);
        });
    }
};
