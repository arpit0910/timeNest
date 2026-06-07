<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('user_id')->nullable()->comment('Actor. NULL = system-triggered.');
            $table->unsignedBigInteger('organization_id')->nullable()->comment('Organization context. NULL = platform-level.');
            $table->string('action', 100)->comment('Dot-notation: user.created, membership.revoked');
            $table->string('resource_type', 100)->nullable()->comment('Eloquent model class');
            $table->unsignedBigInteger('resource_id')->nullable()->comment('Integer ID of affected resource');
            $table->string('resource_uuid', 36)->nullable()->comment('UUID of affected resource');
            $table->json('old_values')->nullable()->comment('State before the action');
            $table->json('new_values')->nullable()->comment('State after the action');
            $table->string('ip_address', 45)->nullable()->comment('Requester IP');
            $table->string('user_agent', 500)->nullable()->comment('Requester user agent');
            $table->json('metadata')->nullable()->comment('Additional structured context');

            // Only created_at — append-only, immutable
            $table->timestamp('created_at')->comment('Immutable. No updated_at.');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('set null');

            $table->index(['organization_id', 'action']);
            $table->index(['user_id', 'created_at']);
            $table->index('action');
            $table->index('created_at');
            $table->index('resource_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
