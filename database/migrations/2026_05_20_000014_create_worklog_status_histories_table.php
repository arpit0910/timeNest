<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('worklog_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_worklog_id')->constrained('attendance_worklogs')->cascadeOnDelete();
            $table->unsignedTinyInteger('old_status');
            $table->unsignedTinyInteger('new_status');
            $table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $table->text('remarks')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worklog_status_histories');
    }
};
