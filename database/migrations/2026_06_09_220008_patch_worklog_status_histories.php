<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step A: Fix timestamp
        Schema::table('worklog_status_histories', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });

        Schema::table('worklog_status_histories', function (Blueprint $table) {
            $table->timestampTz('created_at')->useCurrent();
        });

        // Step B: Add uuid
        if (!Schema::hasColumn('worklog_status_histories', 'uuid')) {
            Schema::table('worklog_status_histories', function (Blueprint $table) {
                $table->uuid('uuid')->unique()->comment('Public UUID');
            });
        }

        // Step C: Fix foreignId constraints
        Schema::table('worklog_status_histories', function (Blueprint $table) {
            $table->dropForeign(['attendance_worklog_id']);
            $table->dropForeign(['changed_by']);
        });

        Schema::table('worklog_status_histories', function (Blueprint $table) {
            $table->foreign('attendance_worklog_id', 'worklog_status_histories_worklog_id_foreign')
                ->references('id')->on('attendance_worklogs')->onDelete('cascade');
            $table->foreign('changed_by', 'worklog_status_histories_changed_by_foreign')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('worklog_status_histories', 'uuid')) {
            Schema::table('worklog_status_histories', function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
};
