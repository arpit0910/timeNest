<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step A: Remove incorrect FK constraints, keep columns
        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['milestone_id']);
            $table->dropForeign(['task_id']);
        });

        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->comment('Soft reference to projects table. FK constraint intentionally absent. Will be added when project management module is built.')->change();
            $table->unsignedBigInteger('milestone_id')->nullable()->comment('Soft reference to milestones table. FK constraint intentionally absent. Will be added when project management module is built.')->change();
            $table->unsignedBigInteger('task_id')->nullable()->comment('Soft reference to tasks table. FK constraint intentionally absent. Will be added when project management module is built.')->change();
        });

        // Step B: Fix timestamp timezone inconsistency
        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->dropColumn([
                'start_time',
                'end_time',
                'submitted_at',
                'approved_at',
                'rejected_at',
                'created_at',
                'updated_at',
                'deleted_at'
            ]);
        });

        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->timestampTz('start_time')->nullable();
            $table->timestampTz('end_time')->nullable();
            $table->timestampTz('submitted_at')->nullable();
            $table->timestampTz('approved_at')->nullable();
            $table->timestampTz('rejected_at')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });

        // Step C: Add missing columns & Step D: Fix anonymous FK constraints
        Schema::table('attendance_worklogs', function (Blueprint $table) {
            // New columns
            $table->unsignedBigInteger('worklog_policy_version_id')
                ->nullable()
                ->comment('FK to worklog_policy_versions. Snapshot of the worklog policy active when this entry was submitted. Ensures policy changes do not alter historical worklog evaluation. This is how old worklog data is protected when an org switches policies.');
            $table->unsignedTinyInteger('approval_flow_snapshot')
                ->nullable()
                ->comment('Approval flow active at submission. Auto=1, SingleApproval=2, MultiLevelApproval=3. Stored for fast filtering without joining policy version table.');
            
            $table->unsignedBigInteger('submitted_by')
                ->nullable()
                ->comment('FK to users. The user who actually submitted this worklog. May differ from user_id when a manager or admin submits on behalf of an employee via the admin panel.');
            
            $table->boolean('billable')
                ->nullable()
                ->comment('Whether this worklog time is billable to a client. Null means not yet classified. Only relevant when worklog_policies.billable_tracking_enabled is true for this org.');

            $table->unsignedBigInteger('second_approver_id')
                ->nullable()
                ->comment('FK to users. Second-level approver in MultiLevelApproval flow.');
            $table->timestampTz('second_approved_at')
                ->nullable()
                ->comment('Timestamp of second-level approval in MultiLevelApproval flow.');

            $table->unsignedBigInteger('second_rejected_by')
                ->nullable()
                ->comment('FK to users. Second-level rejector in MultiLevelApproval flow.');
            $table->timestampTz('second_rejected_at')
                ->nullable()
                ->comment('Timestamp of second-level rejection in MultiLevelApproval flow.');

            // Add new FK constraints
            $table->foreign('worklog_policy_version_id', 'att_worklogs_worklog_policy_version_id_foreign')
                ->references('id')->on('worklog_policy_versions')->onDelete('set null');
            $table->foreign('submitted_by', 'att_worklogs_submitted_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('second_approver_id', 'att_worklogs_second_approver_id_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('second_rejected_by', 'att_worklogs_second_rejected_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });

        // Separate closure for dropping old anonymous FKs
        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['attendance_day_id']);
            $table->dropForeign(['attendance_session_id']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        // Separate closure for adding explicit FKs
        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->foreign('organization_id', 'attendance_worklogs_organization_id_foreign')
                ->references('id')->on('organizations')->onDelete('cascade');

            $table->foreign('user_id', 'attendance_worklogs_user_id_foreign')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('attendance_day_id', 'attendance_worklogs_attendance_day_id_foreign')
                ->references('id')->on('attendance_days')->onDelete('cascade');

            $table->foreign('attendance_session_id', 'att_worklogs_attendance_session_id_foreign')
                ->references('id')->on('attendance_sessions')->onDelete('set null');

            $table->foreign('approved_by', 'attendance_worklogs_approved_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->foreign('rejected_by', 'attendance_worklogs_rejected_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->foreign('created_by', 'attendance_worklogs_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->foreign('updated_by', 'attendance_worklogs_updated_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->dropForeign('att_worklogs_worklog_policy_version_id_foreign');
            $table->dropForeign('att_worklogs_submitted_by_foreign');
            $table->dropForeign('att_worklogs_second_approver_id_foreign');
            $table->dropForeign('att_worklogs_second_rejected_by_foreign');

            $table->dropColumn([
                'worklog_policy_version_id',
                'approval_flow_snapshot',
                'submitted_by',
                'billable',
                'second_approver_id',
                'second_approved_at',
                'second_rejected_by',
                'second_rejected_at',
                'start_time',
                'end_time',
                'submitted_at',
                'approved_at',
                'rejected_at',
                'created_at',
                'updated_at',
                'deleted_at'
            ]);
        });

        Schema::table('attendance_worklogs', function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
