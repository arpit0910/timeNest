<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_type_id')
                ->nullable()
                ->after('leave_type')
                ->comment('FK to leave_types. Nullable for backward compatibility. All new leave submissions must populate this. Determines which type-specific rules apply.');
            
            $table->unsignedBigInteger('leave_policy_version_id')
                ->nullable()
                ->after('leave_type_id')
                ->comment('FK to leave_policy_versions. Snapshot of the leave policy active when this request was submitted. Ensures policy changes do not retroactively affect existing requests. This is how old leave data is protected when an org switches policies.');
            
            $table->unsignedTinyInteger('approval_flow_snapshot')
                ->nullable()
                ->after('leave_policy_version_id')
                ->comment('Records which approval flow was active at submission time. Auto=1, SingleApproval=2, MultiLevelApproval=3. Stored independently for fast filtering without joining the policy version table.');

            $table->boolean('is_carry_forward')
                ->default(false)
                ->after('total_days')
                ->comment('Whether the days consumed by this request were deducted from the carried-forward balance rather than the current year allocation.');

            $table->timestampTz('auto_approved_at')
                ->nullable()
                ->after('approved_at')
                ->comment('Timestamp when the system automatically approved this leave. Populated for Auto flow approvals or auto_approve_after_hours timeout triggers. Null for manual approvals.');

            $table->unsignedBigInteger('second_approver_id')
                ->nullable()
                ->after('approved_by')
                ->comment('FK to users. The second-level approver in MultiLevelApproval flow. Null for Auto and SingleApproval flows.');
            
            $table->timestampTz('second_approved_at')
                ->nullable()
                ->after('second_approver_id')
                ->comment('Timestamp when second-level approval was granted in MultiLevelApproval flow.');

            $table->unsignedBigInteger('second_rejected_by')
                ->nullable()
                ->after('rejected_by')
                ->comment('FK to users. Second-level actor who rejected in MultiLevelApproval flow.');

            $table->timestampTz('second_rejected_at')
                ->nullable()
                ->after('second_rejected_by')
                ->comment('Timestamp when second-level rejection occurred in MultiLevelApproval flow.');

            $table->foreign('leave_type_id', 'employee_leaves_leave_type_id_foreign')
                ->references('id')->on('leave_types')->onDelete('set null');
            $table->foreign('leave_policy_version_id', 'employee_leaves_leave_policy_version_id_foreign')
                ->references('id')->on('leave_policy_versions')->onDelete('set null');
            $table->foreign('second_approver_id', 'employee_leaves_second_approver_id_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('second_rejected_by', 'employee_leaves_second_rejected_by_foreign')
                ->references('id')->on('users')->onDelete('set null');

            $table->index('leave_type_id');
            $table->index('leave_policy_version_id');
        });
    }

    public function down(): void
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->dropForeign('employee_leaves_leave_type_id_foreign');
            $table->dropForeign('employee_leaves_leave_policy_version_id_foreign');
            $table->dropForeign('employee_leaves_second_approver_id_foreign');
            $table->dropForeign('employee_leaves_second_rejected_by_foreign');

            $table->dropIndex(['leave_type_id']);
            $table->dropIndex(['leave_policy_version_id']);

            $table->dropColumn([
                'leave_type_id',
                'leave_policy_version_id',
                'approval_flow_snapshot',
                'is_carry_forward',
                'auto_approved_at',
                'second_approver_id',
                'second_approved_at',
                'second_rejected_by',
                'second_rejected_at'
            ]);
        });
    }
};
