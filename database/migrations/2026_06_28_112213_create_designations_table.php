<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')
                  ->nullable()
                  ->constrained('organizations')
                  ->cascadeOnDelete();
            $table->foreignId('sub_department_id')
                  ->constrained('sub_departments')
                  ->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('level')->default(1);
            // level: 1=junior, 2=mid, 3=senior, 4=lead, 5=principal/head
            // used for seniority ordering only, not for permissions
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'sub_department_id', 'slug']);
            $table->index(['organization_id', 'is_active']);
            $table->index(['sub_department_id', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
