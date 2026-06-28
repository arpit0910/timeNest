<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['parent_department_id']);
            $table->dropColumn('parent_department_id');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('parent_department_id')
                  ->nullable()
                  ->constrained('departments')
                  ->nullOnDelete();
        });
    }
};
