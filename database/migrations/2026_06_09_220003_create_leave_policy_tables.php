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
         * approval_flow: Auto=1, SingleApproval=2, MultiLevelApproval=3
         * accrual_frequency: Monthly=1, Quarterly=2
         */

        Schema::create('leave_policies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')
                ->unique()
                ->comment('FK to organizations. One active leave policy per org.');

            $table->unsignedTinyInteger('approval_flow')
                ->comment('Auto=1, SingleApproval=2, MultiLevelApproval=3. Controls how leave requests are reviewed and approved.');

            $table->boolean('allow_half_day_leaves')
                ->default(true)
                ->comment('Master switch for half-day leave across this org. Individual leave types can further restrict this.');
            $table->boolean('allow_leave_on_weekends')
                ->default(false)
                ->comment('Whether a leave request can include days defined as weekends in the attendance policy. If false, weekend days within a leave range are automatically excluded from the day count.');
            $table->boolean('allow_leave_on_holidays')
                ->default(false)
                ->comment('Whether a leave request can include organization-defined holidays. If false, holiday days within a leave range are automatically excluded.');
            $table->unsignedTinyInteger('advance_notice_required_days')
                ->default(1)
                ->comment('Minimum calendar days in advance a leave request must be submitted before the leave start date.');
            $table->unsignedTinyInteger('max_advance_application_days')
                ->default(90)
                ->comment('Maximum calendar days in advance an employee can apply for leave. Prevents excessively forward-dated applications.');

            $table->unsignedTinyInteger('document_required_after_days')
                ->default(3)
                ->comment('If a leave request duration exceeds this number of consecutive days, a supporting document attachment becomes mandatory.');

            $table->boolean('allow_leave_cancellation')
                ->default(true)
                ->comment('Whether an employee can cancel an already approved leave.');
            $table->unsignedSmallInteger('cancellation_before_hours')
                ->default(24)
                ->comment('Minimum hours before the leave start time within which a cancellation request must be submitted. Prevents last-minute cancellations.');

            $table->boolean('carry_forward_enabled')
                ->default(false)
                ->comment('Whether unused leave balance at year-end carries forward to the next year.');
            $table->unsignedTinyInteger('max_carry_forward_days')
                ->default(0)
                ->comment('Maximum unused leave days that can be carried forward per year. 0 means no carry forward even if carry_forward_enabled is true.');
            $table->unsignedTinyInteger('carry_forward_expiry_months')
                ->default(3)
                ->comment('Months after the start of the new year within which carried-forward leave must be used before it expires.');

            $table->boolean('accrual_enabled')
                ->default(false)
                ->comment('Whether leave balance is accrued incrementally over the year instead of being granted in full upfront annually.');
            $table->unsignedTinyInteger('accrual_frequency')
                ->nullable()
                ->comment('Monthly=1, Quarterly=2. Frequency at which leave balance is accrued. Null if accrual_enabled is false.');

            $table->boolean('negative_balance_allowed')
                ->default(false)
                ->comment('Whether employee can submit a leave request when their balance is zero or insufficient. Results in a negative balance to be recovered.');

            $table->unsignedSmallInteger('auto_approve_after_hours')
                ->nullable()
                ->comment('For SingleApproval flow: if the assigned approver has not acted within this many hours of submission, the leave is automatically approved. Null means no auto-approval timeout.');

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
            $table->foreign('created_by', 'leave_policies_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by', 'leave_policies_updated_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('leave_policy_versions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->unsignedBigInteger('leave_policy_id')
                ->comment('FK to leave_policies');
            $table->unsignedInteger('version')
                ->comment('Sequential version number. Immutable once written.');
            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->comment('FK to users. User whose action triggered this snapshot.');

            $table->unsignedBigInteger('organization_id')
                ->comment('FK to organizations. One active leave policy per org.');

            $table->unsignedTinyInteger('approval_flow')
                ->comment('Auto=1, SingleApproval=2, MultiLevelApproval=3. Controls how leave requests are reviewed and approved.');

            $table->boolean('allow_half_day_leaves')
                ->default(true)
                ->comment('Master switch for half-day leave across this org. Individual leave types can further restrict this.');
            $table->boolean('allow_leave_on_weekends')
                ->default(false)
                ->comment('Whether a leave request can include days defined as weekends in the attendance policy. If false, weekend days within a leave range are automatically excluded from the day count.');
            $table->boolean('allow_leave_on_holidays')
                ->default(false)
                ->comment('Whether a leave request can include organization-defined holidays. If false, holiday days within a leave range are automatically excluded.');
            $table->unsignedTinyInteger('advance_notice_required_days')
                ->default(1)
                ->comment('Minimum calendar days in advance a leave request must be submitted before the leave start date.');
            $table->unsignedTinyInteger('max_advance_application_days')
                ->default(90)
                ->comment('Maximum calendar days in advance an employee can apply for leave. Prevents excessively forward-dated applications.');

            $table->unsignedTinyInteger('document_required_after_days')
                ->default(3)
                ->comment('If a leave request duration exceeds this number of consecutive days, a supporting document attachment becomes mandatory.');

            $table->boolean('allow_leave_cancellation')
                ->default(true)
                ->comment('Whether an employee can cancel an already approved leave.');
            $table->unsignedSmallInteger('cancellation_before_hours')
                ->default(24)
                ->comment('Minimum hours before the leave start time within which a cancellation request must be submitted. Prevents last-minute cancellations.');

            $table->boolean('carry_forward_enabled')
                ->default(false)
                ->comment('Whether unused leave balance at year-end carries forward to the next year.');
            $table->unsignedTinyInteger('max_carry_forward_days')
                ->default(0)
                ->comment('Maximum unused leave days that can be carried forward per year. 0 means no carry forward even if carry_forward_enabled is true.');
            $table->unsignedTinyInteger('carry_forward_expiry_months')
                ->default(3)
                ->comment('Months after the start of the new year within which carried-forward leave must be used before it expires.');

            $table->boolean('accrual_enabled')
                ->default(false)
                ->comment('Whether leave balance is accrued incrementally over the year instead of being granted in full upfront annually.');
            $table->unsignedTinyInteger('accrual_frequency')
                ->nullable()
                ->comment('Monthly=1, Quarterly=2. Frequency at which leave balance is accrued. Null if accrual_enabled is false.');

            $table->boolean('negative_balance_allowed')
                ->default(false)
                ->comment('Whether employee can submit a leave request when their balance is zero or insufficient. Results in a negative balance to be recovered.');

            $table->unsignedSmallInteger('auto_approve_after_hours')
                ->nullable()
                ->comment('For SingleApproval flow: if the assigned approver has not acted within this many hours of submission, the leave is automatically approved. Null means no auto-approval timeout.');

            $table->timestampTz('created_at');

            $table->foreign('leave_policy_id', 'leave_policy_versions_policy_id_foreign')
                ->references('id')->on('leave_policies')->onDelete('cascade');
            $table->foreign('created_by', 'leave_policy_versions_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->unique(['leave_policy_id', 'version'], 'leave_policy_versions_policy_id_version_unique');
        });

        Schema::create('leave_types', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')
                ->comment('FK to organizations');
            $table->unsignedBigInteger('leave_policy_id')
                ->comment('FK to leave_policies. The policy this type belongs to.');

            $table->string('name', 100)
                ->comment('Display name shown to employees. e.g. Casual Leave, Sick Leave, Earned Leave.');
            $table->string('code', 50)
                ->comment('Internal code used in API and business logic. e.g. CASUAL, SICK, UNPAID. Unique per organization.');
            $table->string('color_hex', 7)
                ->nullable()
                ->comment('Hex color for frontend calendar display. e.g. #FF5733. Nullable.');

            $table->boolean('is_paid')
                ->default(true)
                ->comment('Whether leave taken under this type is paid.');
            $table->boolean('is_system_type')
                ->default(false)
                ->comment('True for leave types seeded by the system during org setup. System types cannot be deleted by org admins, only deactivated.');

            $table->boolean('requires_document')
                ->default(false)
                ->comment('Whether a supporting document is always required for this leave type regardless of duration. Overrides leave_policies.document_required_after_days for this type.');
            $table->boolean('allow_half_day')
                ->default(true)
                ->comment('Whether half-day leave is permitted for this type. Subject to leave_policies.allow_half_day_leaves being true at the org level.');

            $table->decimal('annual_allocation_days', 5, 2)
                ->comment('Total leave days granted per employee per year for this type. Decimal supports fractional allocations e.g. 1.5 days.');
            $table->unsignedTinyInteger('max_per_request_days')
                ->nullable()
                ->comment('Maximum days in a single leave request for this type. Null means no per-request cap.');
            $table->decimal('min_per_request_days', 3, 2)
                ->default(0.50)
                ->comment('Minimum days for a single leave request. 0.5 allows half-day as minimum. 1.0 requires full day minimum.');

            $table->boolean('is_active')
                ->default(true)
                ->comment('Whether this leave type is currently available for employee applications. Inactive types are hidden from employees but retained for historical records.');
            $table->unsignedTinyInteger('sort_order')
                ->default(0)
                ->comment('Display order in UI leave type selectors. Lower values appear first.');

            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->comment('FK to users');
            $table->unsignedBigInteger('updated_by')
                ->nullable()
                ->comment('FK to users');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('organization_id', 'leave_types_organization_id_foreign')
                ->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('leave_policy_id', 'leave_types_leave_policy_id_foreign')
                ->references('id')->on('leave_policies')->onDelete('cascade');
            $table->foreign('created_by', 'leave_types_created_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by', 'leave_types_updated_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->unique(['organization_id', 'code'], 'leave_types_organization_id_code_unique');
            $table->index(['leave_policy_id', 'is_active'], 'leave_types_policy_id_is_active_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leave_policy_versions');
        Schema::dropIfExists('leave_policies');
    }
};
