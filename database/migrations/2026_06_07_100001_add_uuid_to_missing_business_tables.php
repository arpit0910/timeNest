<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'leave_status_histories',
            'worklog_status_histories',
            'task_time_consumptions',
            'worklog_policies'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'uuid')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->uuid('uuid')->nullable()->after('id');
                });

                // Populate uuid
                DB::table($table)->whereNull('uuid')->chunkById(100, function ($records) use ($table) {
                    foreach ($records as $record) {
                        DB::table($table)
                            ->where('id', $record->id)
                            ->update(['uuid' => (string) Str::uuid()]);
                    }
                });

                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->uuid('uuid')->nullable(false)->unique()->change();
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'leave_status_histories',
            'worklog_status_histories',
            'task_time_consumptions',
            'worklog_policies'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'uuid')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->dropColumn('uuid');
                });
            }
        }
    }
};
