<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('worklog_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_policy_id')->constrained('attendance_policies')->cascadeOnDelete()->unique();
            $table->boolean('require_worklog_on_clockout')->default(false);
            $table->boolean('allow_deferred_submission')->default(true);
            $table->boolean('require_project_mapping')->default(false);
            $table->boolean('require_task_mapping')->default(false);
            $table->boolean('require_justification_on_overflow')->default(true);
            $table->boolean('auto_escalate_overdue_logs')->default(false);
            $table->unsignedTinyInteger('overdue_after_days')->default(1);
            $table->unsignedTinyInteger('lock_after_days')->default(3);
            $table->boolean('allow_multiple_worklogs_per_session')->default(true);
            $table->boolean('strict_mode_enabled')->default(false);
            $table->boolean('flexible_mode_enabled')->default(true);
            $table->boolean('hybrid_mode_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worklog_policies');
    }
};
