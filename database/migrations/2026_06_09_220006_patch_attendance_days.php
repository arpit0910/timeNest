<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance_days', function (Blueprint $table) {
            $table->unsignedTinyInteger('approval_flow_snapshot')
                ->nullable()
                ->after('attendance_policy_version_id')
                ->comment('Records which approval flow was active when this attendance day was processed. Auto=1, SingleApproval=2, MultiLevelApproval=3. Relevant for manual correction and override request tracking.');

            $table->unsignedInteger('early_exit_minutes')
                ->default(0)
                ->after('late_minutes')
                ->comment('Minutes by which employee left before shift_end_time. 0 means no early exit detected. Only populated in Strict attendance_mode.');

            $table->unsignedBigInteger('approved_by')
                ->nullable()
                ->after('early_exit_minutes')
                ->comment('FK to users. Manager who approved a manual attendance correction or override for this day. Null for system-generated records requiring no correction.');

            $table->timestampTz('approved_at')
                ->nullable()
                ->after('approved_by')
                ->comment('Timestamp when the manual attendance correction was approved.');

            $table->unsignedBigInteger('second_approver_id')
                ->nullable()
                ->after('approved_at')
                ->comment('FK to users. Second-level approver for MultiLevelApproval flow on manual attendance corrections.');

            $table->timestampTz('second_approved_at')
                ->nullable()
                ->after('second_approver_id')
                ->comment('Timestamp of second-level approval for manual attendance correction in MultiLevelApproval flow.');

            $table->foreign('approved_by', 'attendance_days_approved_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
            $table->foreign('second_approver_id', 'attendance_days_second_approver_id_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('attendance_days', function (Blueprint $table) {
            $table->dropForeign('attendance_days_approved_by_foreign');
            $table->dropForeign('attendance_days_second_approver_id_foreign');

            $table->dropColumn([
                'approval_flow_snapshot',
                'early_exit_minutes',
                'approved_by',
                'approved_at',
                'second_approver_id',
                'second_approved_at'
            ]);
        });
    }
};
