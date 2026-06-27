<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds department_id to organization_memberships for Option B role architecture.
 *
 * This column stores the department scope context for roles like HEAD and
 * DEPARTMENT_ADMIN. It is nullable because org-wide roles (director,
 * super_admin, admin, viewer) do not belong to a specific department.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_memberships', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')
                ->nullable()
                ->after('organization_id')
                ->comment('Department scope for department-scoped roles (HEAD, DEPARTMENT_ADMIN)');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->nullOnDelete();

            $table->index('department_id');
        });
    }

    public function down(): void
    {
        Schema::table('organization_memberships', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropIndex(['department_id']);
            $table->dropColumn('department_id');
        });
    }
};
