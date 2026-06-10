<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Enums used in this migration:
         *
         * attendance_mode:
         *   Strict=1:   Enforces exact shift times. Late arrivals, early
         *               exits, and short sessions are all penalized.
         *   Flexible=2: Only tracks total hours worked per day. No shift
         *               time enforcement.
         *   Hybrid=3:   Enforces shift start time only. Exit time is
         *               flexible as long as required_daily_minutes is met.
         *
         * approval_flow: Auto=1, SingleApproval=2, MultiLevelApproval=3
         *   Auto:               Manual corrections are immediately accepted.
         *   SingleApproval:     Direct manager must approve.
         *   MultiLevelApproval: Manager approves first, then HR/Admin/Owner.
         */

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('attendance_work_duration_penalty_slabs');
        Schema::dropIfExists('attendance_late_penalty_slabs');
        Schema::dropIfExists('attendance_policy_versions');
        Schema::dropIfExists('attendance_policies');
        Schema::enableForeignKeyConstraints();

        Schema::create('attendance_policies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')
                ->unique()
                ->comment('FK to organizations. One active attendance policy per org.');

            $table->unsignedTinyInteger('attendance_mode')
                ->comment('Strict=1, Flexible=2, Hybrid=3');
            $table->unsignedTinyInteger('approval_flow')
                ->comment('Auto=1, SingleApproval=2, MultiLevelApproval=3. Controls how manual attendance corrections and overrides are reviewed. Independent from worklog and leave approval flows.');

            $table->time('shift_start_time')
                ->default('09:00:00')
                ->comment('Scheduled shift start time. Used for late arrival detection in Strict and Hybrid modes.');
            $table->time('shift_end_time')
                ->default('18:00:00')
                ->comment('Scheduled shift end time. Used for early exit detection in Strict mode.');

            $table->unsignedInteger('required_daily_minutes')
                ->comment('Minimum total work minutes per day to be marked Present. Sessions below this threshold result in HalfDay or Absent status.');
            $table->unsignedInteger('minimum_session_minutes')
                ->comment('Minimum duration of a single clock-in/out session to count as valid work time. Sessions shorter than this are discarded from the daily total.');

            $table->unsignedInteger('grace_late_minutes')
                ->comment('Minutes after shift_start_time within which an arrival is still considered on-time. Only applies in Strict and Hybrid modes.');
            $table->unsignedTinyInteger('allowed_monthly_late_count')
                ->comment('Number of late arrivals permitted per calendar month before late penalty slabs activate.');

            $table->boolean('allow_early_exit')
                ->default(true)
                ->comment('Whether leaving before shift_end_time is permitted. If false, early exit is flagged as a compliance violation.');
            $table->unsignedInteger('grace_early_exit_minutes')
                ->default(0)
                ->comment('Minutes before shift_end_time that early exit is still tolerated without flagging. Only relevant if allow_early_exit is true.');

            $table->unsignedInteger('default_break_minutes')
                ->comment('Standard unpaid break duration deducted from total session time per day during payroll calculation.');
            $table->unsignedInteger('max_break_minutes')
                ->comment('Maximum break minutes permitted per day. Time in breaks beyond this threshold is deducted from total work time.');

            $table->boolean('allow_multiple_sessions')
                ->default(true)
                ->comment('Whether employee can clock in and out multiple times per day. If false, only the first session of the day is accepted.');
            $table->boolean('allow_clock_in_on_holidays')
                ->default(false)
                ->comment('Whether clock-in is permitted on organization-defined holidays.');

            $table->boolean('auto_clock_out_enabled')
                ->default(false)
                ->comment('Whether the system automatically clocks out an employee after a threshold duration since their last clock-in.');
            $table->unsignedInteger('auto_clock_out_after_minutes')
                ->default(0)
                ->comment('Minutes after clock-in at which auto clock-out is triggered. Only relevant if auto_clock_out_enabled is true.');

            $table->boolean('overtime_enabled')
                ->default(false)
                ->comment('Whether overtime tracking is active for this org.');
            $table->unsignedInteger('overtime_starts_after_minutes')
                ->default(0)
                ->comment('Work minutes per day beyond which time is counted as overtime. e.g. 480 means overtime begins after 8 hours. Only relevant if overtime_enabled is true.');
            $table->unsignedInteger('max_daily_overtime_minutes')
                ->default(0)
                ->comment('Cap on daily overtime minutes recorded. Excess above this cap is ignored. 0 means no cap.');
            $table->boolean('overtime_requires_approval')
                ->default(false)
                ->comment('Whether overtime must be explicitly approved before being counted. If true, overtime minutes remain pending until approved by manager.');

            $table->json('weekend_days')
                ->comment('JSON array of ISO weekday integers treated as weekend for this org. e.g. [6,7] for Saturday+Sunday, [5,6] for Friday+Saturday. Drives Weekend status on attendance_days and leave exclusion logic.');

            $table->boolean('geo_fencing_enabled')
                ->default(false)
                ->comment('Whether location-based clock-in restriction is enforced. If true, clock-in is only valid within geo_fence_radius_meters of the org registered location.');
            $table->unsignedInteger('geo_fence_radius_meters')
                ->default(0)
                ->comment('Radius in meters from org location within which clock-in is valid. Only relevant if geo_fencing_enabled is true.');
            $table->boolean('ip_restriction_enabled')
                ->default(false)
                ->comment('Whether clock-in is restricted to a set of whitelisted IP addresses configured separately in org settings.');

            $table->boolean('strict_worklog_enforcement')
                ->default(false)
                ->comment('If true, employee cannot clock in for a new working day until the previous day worklog has been submitted. Enforced at clock-in time.');

            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->comment('FK to users. The user who created this policy.');
            $table->unsignedBigInteger('updated_by')
                ->nullable()
                ->comment('FK to users. The user who last modified this policy.');
            
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('organization_id')
                ->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('created_by', 'attendance_policies_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by', 'attendance_policies_updated_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->index(['organization_id', 'attendance_mode']);
        });

        Schema::create('attendance_policy_versions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->unsignedBigInteger('attendance_policy_id')
                ->comment('FK to attendance_policies. The parent policy this snapshot belongs to.');
            $table->unsignedInteger('version')
                ->comment('Sequential version number. Starts at 1 and increments on every policy change. The combination of attendance_policy_id + version is unique and immutable.');
            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->comment('FK to users. The user whose action triggered this version snapshot.');

            $table->unsignedBigInteger('organization_id')
                ->comment('FK to organizations. One active attendance policy per org.');

            $table->unsignedTinyInteger('attendance_mode')
                ->comment('Strict=1, Flexible=2, Hybrid=3');
            $table->unsignedTinyInteger('approval_flow')
                ->comment('Auto=1, SingleApproval=2, MultiLevelApproval=3. Controls how manual attendance corrections and overrides are reviewed. Independent from worklog and leave approval flows.');

            $table->time('shift_start_time')
                ->default('09:00:00')
                ->comment('Scheduled shift start time. Used for late arrival detection in Strict and Hybrid modes.');
            $table->time('shift_end_time')
                ->default('18:00:00')
                ->comment('Scheduled shift end time. Used for early exit detection in Strict mode.');

            $table->unsignedInteger('required_daily_minutes')
                ->comment('Minimum total work minutes per day to be marked Present. Sessions below this threshold result in HalfDay or Absent status.');
            $table->unsignedInteger('minimum_session_minutes')
                ->comment('Minimum duration of a single clock-in/out session to count as valid work time. Sessions shorter than this are discarded from the daily total.');

            $table->unsignedInteger('grace_late_minutes')
                ->comment('Minutes after shift_start_time within which an arrival is still considered on-time. Only applies in Strict and Hybrid modes.');
            $table->unsignedTinyInteger('allowed_monthly_late_count')
                ->comment('Number of late arrivals permitted per calendar month before late penalty slabs activate.');

            $table->boolean('allow_early_exit')
                ->default(true)
                ->comment('Whether leaving before shift_end_time is permitted. If false, early exit is flagged as a compliance violation.');
            $table->unsignedInteger('grace_early_exit_minutes')
                ->default(0)
                ->comment('Minutes before shift_end_time that early exit is still tolerated without flagging. Only relevant if allow_early_exit is true.');

            $table->unsignedInteger('default_break_minutes')
                ->comment('Standard unpaid break duration deducted from total session time per day during payroll calculation.');
            $table->unsignedInteger('max_break_minutes')
                ->comment('Maximum break minutes permitted per day. Time in breaks beyond this threshold is deducted from total work time.');

            $table->boolean('allow_multiple_sessions')
                ->default(true)
                ->comment('Whether employee can clock in and out multiple times per day. If false, only the first session of the day is accepted.');
            $table->boolean('allow_clock_in_on_holidays')
                ->default(false)
                ->comment('Whether clock-in is permitted on organization-defined holidays.');

            $table->boolean('auto_clock_out_enabled')
                ->default(false)
                ->comment('Whether the system automatically clocks out an employee after a threshold duration since their last clock-in.');
            $table->unsignedInteger('auto_clock_out_after_minutes')
                ->default(0)
                ->comment('Minutes after clock-in at which auto clock-out is triggered. Only relevant if auto_clock_out_enabled is true.');

            $table->boolean('overtime_enabled')
                ->default(false)
                ->comment('Whether overtime tracking is active for this org.');
            $table->unsignedInteger('overtime_starts_after_minutes')
                ->default(0)
                ->comment('Work minutes per day beyond which time is counted as overtime. e.g. 480 means overtime begins after 8 hours. Only relevant if overtime_enabled is true.');
            $table->unsignedInteger('max_daily_overtime_minutes')
                ->default(0)
                ->comment('Cap on daily overtime minutes recorded. Excess above this cap is ignored. 0 means no cap.');
            $table->boolean('overtime_requires_approval')
                ->default(false)
                ->comment('Whether overtime must be explicitly approved before being counted. If true, overtime minutes remain pending until approved by manager.');

            $table->json('weekend_days')
                ->comment('JSON array of ISO weekday integers treated as weekend for this org. e.g. [6,7] for Saturday+Sunday, [5,6] for Friday+Saturday. Drives Weekend status on attendance_days and leave exclusion logic.');

            $table->boolean('geo_fencing_enabled')
                ->default(false)
                ->comment('Whether location-based clock-in restriction is enforced. If true, clock-in is only valid within geo_fence_radius_meters of the org registered location.');
            $table->unsignedInteger('geo_fence_radius_meters')
                ->default(0)
                ->comment('Radius in meters from org location within which clock-in is valid. Only relevant if geo_fencing_enabled is true.');
            $table->boolean('ip_restriction_enabled')
                ->default(false)
                ->comment('Whether clock-in is restricted to a set of whitelisted IP addresses configured separately in org settings.');

            $table->boolean('strict_worklog_enforcement')
                ->default(false)
                ->comment('If true, employee cannot clock in for a new working day until the previous day worklog has been submitted. Enforced at clock-in time.');

            $table->timestampTz('created_at');

            $table->foreign('attendance_policy_id', 'att_policy_versions_policy_id_foreign')
                ->references('id')->on('attendance_policies')->onDelete('cascade');
            $table->foreign('created_by', 'att_policy_versions_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->unique(['attendance_policy_id', 'version'], 'att_policy_versions_policy_id_version_unique');
        });

        Schema::create('attendance_late_penalty_slabs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('attendance_policy_id')
                ->comment('FK to attendance_policies');
            $table->unsignedTinyInteger('late_count_threshold')
                ->comment('Monthly late arrival count at which this slab activates. e.g. 3 means this penalty applies from the 3rd late arrival onward.');
            $table->decimal('deduction_percentage', 5, 2)
                ->comment('Salary deduction percentage applied when this threshold is reached or exceeded.');
            $table->timestampsTz();

            $table->foreign('attendance_policy_id', 'att_late_slabs_policy_id_foreign')
                ->references('id')->on('attendance_policies')->onDelete('cascade');
            $table->unique(
                ['attendance_policy_id', 'late_count_threshold'],
                'att_late_slabs_policy_id_threshold_unique'
            );
        });

        Schema::create('attendance_work_duration_penalty_slabs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('attendance_policy_id')
                ->comment('FK to attendance_policies');
            $table->unsignedInteger('min_work_minutes')
                ->comment('Lower bound of this slab range in minutes (inclusive).');
            $table->unsignedInteger('max_work_minutes')
                ->comment('Upper bound of this slab range in minutes (inclusive). Use 9999 for open-ended top slab.');
            $table->decimal('deduction_percentage', 5, 2)
                ->comment('Deduction percentage when daily work duration falls within this slab range.');
            $table->timestampsTz();

            $table->foreign('attendance_policy_id', 'att_work_dur_slabs_policy_id_foreign')
                ->references('id')->on('attendance_policies')->onDelete('cascade');
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
