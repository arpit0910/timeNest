<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step A: Fix timestamps
        Schema::table('attendance_escalations', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at', 'resolved_at']);
        });

        Schema::table('attendance_escalations', function (Blueprint $table) {
            $table->timestampsTz();
            $table->timestampTz('resolved_at')->nullable();
        });

        // Step B: Add missing columns
        Schema::table('attendance_escalations', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_to')
                ->nullable()
                ->after('escalation_status')
                ->comment('FK to users. The manager, admin, or HR user this escalation is assigned to for action. Null if not yet assigned.');

            $table->timestampTz('escalated_at')
                ->nullable()
                ->after('assigned_to')
                ->comment('Timestamp when this escalation was formally triggered. May differ from created_at if a background job processed and escalated after the record was initially written.');

            $table->timestampTz('notified_at')
                ->nullable()
                ->after('escalated_at')
                ->comment('Timestamp when the assigned_to user was sent a notification. Null if notification has not yet been dispatched.');

            $table->foreign('assigned_to', 'attendance_escalations_assigned_to_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });

        // Step C: Fix foreignId constraints (Split into two closures for safety)
        Schema::table('attendance_escalations', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['attendance_day_id']);
            $table->dropForeign(['attendance_worklog_id']);
            $table->dropForeign(['resolved_by']);
        });

        Schema::table('attendance_escalations', function (Blueprint $table) {
            $table->foreign('organization_id', 'attendance_escalations_organization_id_foreign')
                ->references('id')->on('organizations')->onDelete('cascade');

            $table->foreign('user_id', 'attendance_escalations_user_id_foreign')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('attendance_day_id', 'att_escalations_attendance_day_id_foreign')
                ->references('id')->on('attendance_days')->onDelete('cascade');

            $table->foreign('attendance_worklog_id', 'att_escalations_worklog_id_foreign')
                ->references('id')->on('attendance_worklogs')->onDelete('cascade');

            $table->foreign('resolved_by', 'attendance_escalations_resolved_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('attendance_escalations', function (Blueprint $table) {
            $table->dropForeign('attendance_escalations_assigned_to_foreign');

            $table->dropColumn([
                'assigned_to',
                'escalated_at',
                'notified_at',
                'resolved_at',
                'created_at',
                'updated_at'
            ]);
        });

        Schema::table('attendance_escalations', function (Blueprint $table) {
            $table->timestamps();
            $table->timestamp('resolved_at')->nullable();
        });
    }
};
