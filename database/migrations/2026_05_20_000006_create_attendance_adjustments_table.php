<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_adjustment_requests', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('attendance_day_id')->comment('FK to attendance_days');
            $table->unsignedBigInteger('attendance_session_id')->nullable()->comment('FK to attendance_sessions — NULL for new sessions');
            
            $table->unsignedBigInteger('requested_by')->comment('FK to users who requested');
            $table->unsignedTinyInteger('adjustment_type')->comment('ClockInCorrection=1, ClockOutCorrection=2, SessionDeletion=3, ManualAttendance=4');
            $table->unsignedTinyInteger('status')->default(1)->comment('Pending=1, Approved=2, Rejected=3, Cancelled=4');
            
            $table->json('details')->comment('Stores proposed changes (e.g. corrected times, reason)');
            
            $table->unsignedBigInteger('resolved_by')->nullable()->comment('FK to users who approved/rejected');
            $table->timestampTz('resolved_at')->nullable()->comment('When the request was resolved');
            $table->string('rejection_reason', 255)->nullable()->comment('Reason if status is Rejected');

            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('attendance_day_id')->references('id')->on('attendance_days')->onDelete('cascade');
            $table->foreign('attendance_session_id')->references('id')->on('attendance_sessions')->onDelete('cascade');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('set null');

            $table->index('attendance_day_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_adjustment_requests');
    }
};
