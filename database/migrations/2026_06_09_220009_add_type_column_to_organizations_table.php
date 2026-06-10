<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Enums used in this migration:
         *
         * organization type:
         *   Personal=1:     Single-user freelancer workspace. Attendance, leave,
         *                   and worklog modules are suppressed at the API layer.
         *   Team=2:         Small team. Basic attendance and worklog available.
         *                   Leave module is optional.
         *   Organization=3: Full enterprise workspace. All policy-driven modules
         *                   available including leave, multi-level approvals,
         *                   escalations, and reporting.
         */
        Schema::table('organizations', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')
                ->default(3)
                ->comment('Personal=1, Team=2, Organization=3. Determines which modules are exposed for this workspace. Default is 3 (Organization) to preserve behavior for all existing orgs.');

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropColumn('type');
        });
    }
};
