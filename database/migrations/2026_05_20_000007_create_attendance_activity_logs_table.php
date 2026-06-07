<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')->comment('FK to organizations');
            $table->unsignedBigInteger('user_id')->comment('FK to users — employee subject of the log');
            $table->unsignedBigInteger('actor_id')->comment('FK to users — who performed the action');
            
            $table->string('action', 50)->comment('Action name: clock_in, clock_out, leave_approved, etc.');
            $table->json('old_values')->nullable()->comment('Values before the change');
            $table->json('new_values')->nullable()->comment('Values after the change');
            
            $table->string('ip_address', 45)->nullable()->comment('IP address of the caller');
            $table->string('user_agent', 500)->nullable()->comment('User agent of the caller');
            
            $table->timestampTz('created_at')->comment('Timestamp of event in UTC');

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('actor_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['organization_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_activity_logs');
    }
};
