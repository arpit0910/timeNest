<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_days', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('user_id')->comment('FK to users');
            $table->unsignedBigInteger('organization_id')->comment('FK to organizations');
            $table->date('attendance_date')->comment('The working date of attendance');
            
            $table->unsignedTinyInteger('attendance_status')->comment('Absent=1, Present=2, HalfDay=3, Leave=4, Holiday=5, Weekend=6, Incomplete=7');
            $table->unsignedTinyInteger('compliance_status')->comment('Compliant=1, Pending=2, Overdue=3, Escalated=4, PayrollRisk=5');
            
            $table->unsignedInteger('total_work_minutes')->default(0)->comment('Aggregated work minutes');
            $table->unsignedInteger('total_break_minutes')->default(0)->comment('Aggregated break minutes');
            $table->unsignedTinyInteger('total_sessions')->default(0)->comment('Aggregated count of active sessions');
            $table->unsignedInteger('late_minutes')->default(0)->comment('Arrival late minutes');
            $table->unsignedInteger('overtime_minutes')->default(0)->comment('Calculated overtime minutes');

            $table->unsignedBigInteger('attendance_policy_version_id')->nullable()->comment('FK to attendance_policy_versions snapshot used');

            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('attendance_policy_version_id')->references('id')->on('attendance_policy_versions')->onDelete('set null');

            $table->unique(['user_id', 'attendance_date'], 'attendance_days_user_id_attendance_date_unique');
            $table->index(['organization_id', 'attendance_date']);
            $table->index('attendance_status');
            $table->index('compliance_status');
        });

        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('attendance_day_id')->comment('FK to attendance_days');
            
            $table->timestampTz('clock_in_at')->comment('Clock-in time in UTC');
            $table->timestampTz('clock_out_at')->nullable()->comment('Clock-out time in UTC');
            
            $table->string('clock_in_ip', 45)->nullable()->comment('Clock-in IP address');
            $table->string('clock_out_ip', 45)->nullable()->comment('Clock-out IP address');
            
            $table->string('clock_in_device_id', 255)->nullable()->comment('Clock-in device fingerprint');
            $table->string('clock_out_device_id', 255)->nullable()->comment('Clock-out device fingerprint');
            
            $table->decimal('clock_in_accuracy', 8, 2)->nullable()->comment('Clock-in GPS accuracy in meters');
            $table->decimal('clock_out_accuracy', 8, 2)->nullable()->comment('Clock-out GPS accuracy in meters');

            $table->decimal('clock_in_latitude', 10, 7)->nullable()->comment('Clock-in latitude');
            $table->decimal('clock_in_longitude', 10, 7)->nullable()->comment('Clock-in longitude');
            $table->decimal('clock_out_latitude', 10, 7)->nullable()->comment('Clock-out latitude');
            $table->decimal('clock_out_longitude', 10, 7)->nullable()->comment('Clock-out longitude');

            $table->unsignedTinyInteger('clock_in_source')->comment('Mobile=1, Web=2, AdminPanel=3, System=4');
            $table->unsignedTinyInteger('clock_out_source')->nullable()->comment('Mobile=1, Web=2, AdminPanel=3, System=4');

            $table->boolean('is_suspicious')->default(false)->comment('Flagged suspicious by geofence engine');
            $table->string('suspicious_reason', 255)->nullable()->comment('Reason for suspicious flag');

            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('attendance_day_id')->references('id')->on('attendance_days')->onDelete('cascade');

            $table->index('attendance_day_id');
            $table->index('clock_in_at');
            $table->index('clock_out_at');
            $table->index('is_suspicious');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
        Schema::dropIfExists('attendance_days');
    }
};
