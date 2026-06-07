<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_policies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')->unique()->comment('FK to organizations, unique');
            
            $table->unsignedTinyInteger('attendance_mode')->comment('Strict=1, Flexible=2, Hybrid=3');
            $table->unsignedInteger('required_daily_minutes')->comment('Required daily work duration');
            $table->unsignedInteger('minimum_session_minutes')->comment('Min duration for a valid clock-in session');
            $table->unsignedInteger('grace_late_minutes')->comment('Grace period for late arrival');
            $table->unsignedTinyInteger('allowed_monthly_late_count')->comment('Max late arrivals allowed before penalty');
            $table->unsignedInteger('default_break_minutes')->comment('Standard unpaid break duration');
            $table->unsignedTinyInteger('worklog_submission_window_days')->comment('Allowed window to submit worklogs');
            $table->unsignedTinyInteger('worklog_edit_grace_days')->comment('Allowed grace days to edit worklogs');
            
            $table->boolean('allow_multiple_sessions')->default(true)->comment('Allow clock-in/out multiple times');
            $table->boolean('allow_clock_in_on_holidays')->default(false)->comment('Allow clocking in on holidays');
            $table->boolean('auto_clock_out_enabled')->default(false)->comment('Enable auto clock out');
            $table->unsignedInteger('auto_clock_out_minutes')->default(0)->comment('Minutes after which auto clock-out is triggered');
            $table->boolean('strict_worklog_enforcement')->default(false)->comment('Enforce worklog submission before next clock-in');
            $table->time('shift_start_time')->default('09:00:00')->comment('Shift start time for late detection');

            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('created_by', 'attendance_policies_created_by_foreign')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by', 'attendance_policies_updated_by_foreign')->references('id')->on('users')->onDelete('set null');

            $table->index(['organization_id', 'attendance_mode']);
        });

        Schema::create('attendance_policy_versions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('attendance_policy_id')->comment('FK to attendance_policies');
            $table->unsignedInteger('version')->comment('Version number incremented on policy changes');

            $table->unsignedTinyInteger('attendance_mode');
            $table->unsignedInteger('required_daily_minutes');
            $table->unsignedInteger('minimum_session_minutes');
            $table->unsignedInteger('grace_late_minutes');
            $table->unsignedTinyInteger('allowed_monthly_late_count');
            $table->unsignedInteger('default_break_minutes');
            $table->unsignedTinyInteger('worklog_submission_window_days');
            $table->unsignedTinyInteger('worklog_edit_grace_days');
            
            $table->boolean('allow_multiple_sessions');
            $table->boolean('allow_clock_in_on_holidays');
            $table->boolean('auto_clock_out_enabled');
            $table->unsignedInteger('auto_clock_out_minutes');
            $table->boolean('strict_worklog_enforcement');
            $table->time('shift_start_time');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestampsTz();

            $table->foreign('attendance_policy_id', 'attendance_policy_versions_attendance_policy_id_foreign')->references('id')->on('attendance_policies')->onDelete('cascade');
            $table->foreign('created_by', 'attendance_policy_versions_created_by_foreign')->references('id')->on('users')->onDelete('set null');

            $table->unique(['attendance_policy_id', 'version'], 'attendance_policy_versions_attendance_policy_id_version_unique');
        });

        Schema::create('attendance_late_penalty_slabs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('attendance_policy_id')->comment('FK to attendance_policies');
            $table->unsignedTinyInteger('late_count_threshold')->comment('Late count threshold (e.g. 3rd late)');
            $table->decimal('deduction_percentage', 5, 2)->comment('Deduction percentage');
            $table->timestampsTz();

            $table->foreign('attendance_policy_id', 'attendance_late_penalty_slabs_attendance_policy_id_foreign')->references('id')->on('attendance_policies')->onDelete('cascade');
            $table->unique(['attendance_policy_id', 'late_count_threshold'], 'att_late_slabs_policy_id_threshold_unique');
        });

        Schema::create('attendance_work_duration_penalty_slabs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('attendance_policy_id')->comment('FK to attendance_policies');
            $table->unsignedInteger('min_work_minutes')->comment('Minimum work minutes for range');
            $table->unsignedInteger('max_work_minutes')->comment('Maximum work minutes for range');
            $table->decimal('deduction_percentage', 5, 2)->comment('Deduction percentage');
            $table->timestampsTz();

            $table->foreign('attendance_policy_id', 'att_work_slabs_policy_id_foreign')->references('id')->on('attendance_policies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_work_duration_penalty_slabs');
        Schema::dropIfExists('attendance_late_penalty_slabs');
        Schema::dropIfExists('attendance_policy_versions');
        Schema::dropIfExists('attendance_policies');
    }
};
