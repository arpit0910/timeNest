<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_memberships', function (Blueprint $table) {
            $table->foreignId('sub_department_id')
                  ->nullable()
                  ->after('department_id')
                  ->constrained('sub_departments')
                  ->nullOnDelete();

            $table->foreignId('designation_id')
                  ->nullable()
                  ->after('sub_department_id')
                  ->constrained('designations')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('organization_memberships', function (Blueprint $table) {
            $table->dropForeign(['sub_department_id']);
            $table->dropForeign(['designation_id']);
            $table->dropColumn(['sub_department_id', 'designation_id']);
        });
    }
};
