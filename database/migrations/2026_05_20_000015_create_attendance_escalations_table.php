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
        Schema::create('attendance_escalations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('attendance_day_id')->nullable()->constrained('attendance_days')->cascadeOnDelete();
            $table->foreignId('attendance_worklog_id')->nullable()->constrained('attendance_worklogs')->cascadeOnDelete();

            $table->unsignedTinyInteger('escalation_type'); // EscalationTypeEnum
            $table->unsignedTinyInteger('escalation_level')->default(1);
            $table->unsignedTinyInteger('escalation_status')->default(1); // EscalationStatusEnum::Pending

            $table->text('remarks')->nullable();
            $table->json('metadata')->nullable();

            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_escalations');
    }
};
