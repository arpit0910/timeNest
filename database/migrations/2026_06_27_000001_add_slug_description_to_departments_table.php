<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds slug and description columns to the departments table.
 *
 * Part of the Option B role refactor: departments become first-class
 * scope context for organization membership roles.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('code')
                ->comment('URL-friendly slug e.g. hr, finance, sales (auto-generated)');
            $table->text('description')->nullable()->after('slug')
                ->comment('Optional department description');
        });

        // Add unique constraint: one slug per organization
        Schema::table('departments', function (Blueprint $table) {
            $table->unique(['organization_id', 'slug'], 'departments_organization_id_slug_unique');
        });

        // Backfill slug from existing code values (lowercase)
        DB::table('departments')
            ->whereNotNull('code')
            ->whereNull('slug')
            ->update(['slug' => DB::raw('LOWER(code)')]);
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropUnique('departments_organization_id_slug_unique');
            $table->dropColumn(['slug', 'description']);
        });
    }
};
