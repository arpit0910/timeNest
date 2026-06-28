<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_departments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')
                  ->nullable()
                  ->constrained('organizations')
                  ->cascadeOnDelete();
            $table->foreignId('department_id')
                  ->constrained('departments')
                  ->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->foreignId('head_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'department_id', 'slug']);
            $table->index(['organization_id', 'is_active']);
            $table->index(['department_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_departments');
    }
};
