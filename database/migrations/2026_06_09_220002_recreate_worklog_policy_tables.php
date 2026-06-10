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
         * worklog_mode:
         *   Strict=1:   Worklogs must exactly match session clock-in/out times.
         *   Flexible=2: Employee logs time freely. No session time matching.
         *   Hybrid=3:   Worklogs required but time variance from session is
         *               permitted within a threshold.
         *
         * approval_flow: Auto=1, SingleApproval=2, MultiLevelApproval=3
         */

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('worklog_policy_versions');
        Schema::dropIfExists('worklog_policies');
        Schema::enableForeignKeyConstraints();

        Schema::create('worklog_policies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')
                ->unique()
                ->comment('FK to organizations. One active worklog policy per org. Intentionally separate from attendance_policies. An org may have different approval flows for attendance vs worklogs.');

            $table->unsignedTinyInteger('worklog_mode')
                ->comment('Strict=1, Flexible=2, Hybrid=3');
            $table->unsignedTinyInteger('approval_flow')
                ->comment('Auto=1, SingleApproval=2, MultiLevelApproval=3. Independent from attendance_policies.approval_flow.');

            $table->boolean('require_worklog_on_clockout')
                ->default(false)
                ->comment('If true, system prompts employee to submit worklog immediately upon clock-out before the session can close.');
            $table->boolean('allow_deferred_submission')
                ->default(true)
                ->comment('Whether employee can submit worklogs after the session day. If false, worklogs must be submitted on the same day as the session.');
            $table->unsignedTinyInteger('submission_window_days')
                ->comment('Calendar days after the session date within which a worklog submission is accepted. After this window the worklog becomes overdue.');
            $table->unsignedTinyInteger('edit_grace_days')
                ->comment('Calendar days after submission within which the employee can edit their worklog. After this period edits are locked unless admin overrides.');
            $table->unsignedTinyInteger('lock_after_days')
                ->comment('Calendar days after the session date after which the worklog is permanently locked. No submission or edit possible without admin override.');

            $table->boolean('require_description')
                ->default(true)
                ->comment('Whether a text description is mandatory on every worklog submission.');
            $table->unsignedTinyInteger('min_description_length')
                ->default(0)
                ->comment('Minimum character count required for worklog description. 0 means no minimum enforced.');
            $table->boolean('require_justification_on_overflow')
                ->default(true)
                ->comment('Whether employee must provide a justification when logged time exceeds the actual session duration.');

            $table->boolean('require_project_mapping')
                ->default(false)
                ->comment('Whether employee must map worklog to a project. Only enforced when the project management module is active for this org.');
            $table->boolean('require_task_mapping')
                ->default(false)
                ->comment('Whether employee must map worklog to a task. Only enforced when the task module is active for this org.');

            $table->boolean('allow_multiple_worklogs_per_session')
                ->default(true)
                ->comment('Whether employee can submit multiple separate worklog entries against a single attendance session. If false, only one worklog per session is accepted.');

            $table->boolean('auto_escalate_overdue_logs')
                ->default(false)
                ->comment('Whether the system automatically creates an escalation record when a worklog is not submitted within submission_window_days.');

            $table->boolean('billable_tracking_enabled')
                ->default(false)
                ->comment('Whether worklogs can be marked billable or non-billable. Only relevant when the invoice module is active. Enables client billing reports.');

            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->comment('FK to users');
            $table->unsignedBigInteger('updated_by')
                ->nullable()
                ->comment('FK to users');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('organization_id')
                ->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('created_by', 'worklog_policies_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by', 'worklog_policies_updated_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('worklog_policy_versions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->unsignedBigInteger('worklog_policy_id')
                ->comment('FK to worklog_policies');
            $table->unsignedInteger('version')
                ->comment('Sequential version number. Increments on every policy change. Immutable once written.');
            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->comment('FK to users. The user whose action triggered this snapshot.');

            $table->unsignedBigInteger('organization_id')
                ->comment('FK to organizations. One active worklog policy per org. Intentionally separate from attendance_policies. An org may have different approval flows for attendance vs worklogs.');

            $table->unsignedTinyInteger('worklog_mode')
                ->comment('Strict=1, Flexible=2, Hybrid=3');
            $table->unsignedTinyInteger('approval_flow')
                ->comment('Auto=1, SingleApproval=2, MultiLevelApproval=3. Independent from attendance_policies.approval_flow.');

            $table->boolean('require_worklog_on_clockout')
                ->default(false)
                ->comment('If true, system prompts employee to submit worklog immediately upon clock-out before the session can close.');
            $table->boolean('allow_deferred_submission')
                ->default(true)
                ->comment('Whether employee can submit worklogs after the session day. If false, worklogs must be submitted on the same day as the session.');
            $table->unsignedTinyInteger('submission_window_days')
                ->comment('Calendar days after the session date within which a worklog submission is accepted. After this window the worklog becomes overdue.');
            $table->unsignedTinyInteger('edit_grace_days')
                ->comment('Calendar days after submission within which the employee can edit their worklog. After this period edits are locked unless admin overrides.');
            $table->unsignedTinyInteger('lock_after_days')
                ->comment('Calendar days after the session date after which the worklog is permanently locked. No submission or edit possible without admin override.');

            $table->boolean('require_description')
                ->default(true)
                ->comment('Whether a text description is mandatory on every worklog submission.');
            $table->unsignedTinyInteger('min_description_length')
                ->default(0)
                ->comment('Minimum character count required for worklog description. 0 means no minimum enforced.');
            $table->boolean('require_justification_on_overflow')
                ->default(true)
                ->comment('Whether employee must provide a justification when logged time exceeds the actual session duration.');

            $table->boolean('require_project_mapping')
                ->default(false)
                ->comment('Whether employee must map worklog to a project. Only enforced when the project management module is active for this org.');
            $table->boolean('require_task_mapping')
                ->default(false)
                ->comment('Whether employee must map worklog to a task. Only enforced when the task module is active for this org.');

            $table->boolean('allow_multiple_worklogs_per_session')
                ->default(true)
                ->comment('Whether employee can submit multiple separate worklog entries against a single attendance session. If false, only one worklog per session is accepted.');

            $table->boolean('auto_escalate_overdue_logs')
                ->default(false)
                ->comment('Whether the system automatically creates an escalation record when a worklog is not submitted within submission_window_days.');

            $table->boolean('billable_tracking_enabled')
                ->default(false)
                ->comment('Whether worklogs can be marked billable or non-billable. Only relevant when the invoice module is active. Enables client billing reports.');

            $table->timestampTz('created_at');

            $table->foreign('worklog_policy_id', 'worklog_policy_versions_policy_id_foreign')
                ->references('id')->on('worklog_policies')->onDelete('cascade');
            $table->foreign('created_by', 'worklog_policy_versions_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->unique(['worklog_policy_id', 'version'], 'worklog_policy_versions_policy_id_version_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worklog_policy_versions');
        Schema::dropIfExists('worklog_policies');
    }
};
