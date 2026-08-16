<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Separates platform roles from organization roles.
 *
 * `guard_name` is uniformly 'api' across every role, so it cannot distinguish
 * the two tiers, and RoleService::list() consequently returned the app_* roles
 * to any tenant able to read roles. Splitting guards instead would require
 * duplicating all 101 permission rows per guard — Spatie treats a role/permission
 * guard mismatch as a hard failure — which is a high-risk change on a live
 * database. This column is additive and breaks nothing.
 */
return new class extends Migration
{
    /**
     * Roles that administer the platform itself rather than a tenant.
     */
    private const PLATFORM_ROLES = [
        'app_super_admin',
        'app_admin',
        'app_auditor',
        'app_support',
    ];

    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table): void {
            $table->enum('tier', ['platform', 'organization'])
                ->default('organization')
                ->after('organization_id')
                ->index();
        });

        // Everything defaults to 'organization'; only the four app_* roles are
        // promoted, so any custom tenant role added later is correct by default.
        DB::table('roles')
            ->whereIn('name', self::PLATFORM_ROLES)
            ->update(['tier' => 'platform']);
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table): void {
            $table->dropColumn('tier');
        });
    }
};
