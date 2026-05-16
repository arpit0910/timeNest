<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('corporation_id')->nullable()
                  ->comment('NULL = system/global role. Set = corporation-specific custom role.');
            $table->string('name', 100)->comment('Role name in snake_case');
            $table->string('guard', 20)->default('corp')
                  ->comment('Auth guard scope: platform | corp');
            $table->text('description')->nullable()->comment('Human-readable description');
            $table->boolean('is_system_role')->default(false)
                  ->comment('TRUE = seeded by platform, cannot be deleted or renamed');
            $table->unsignedSmallInteger('sort_order')->default(0)->comment('UI display order');

            $table->timestamps();

            $table->foreign('corporation_id')->references('id')->on('corporations')->onDelete('cascade');
            $table->unique(['corporation_id', 'name'], 'unique_role_per_corp');
            $table->index('guard');
            $table->index('is_system_role');
            $table->index('corporation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
