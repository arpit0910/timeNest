<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')->comment('FK to organizations');
            $table->unsignedBigInteger('user_id')->comment('FK to users');
            
            $table->unsignedTinyInteger('leave_type')->comment('Casual=1, Sick=2, Paid=3, Unpaid=4, WorkFromHome=5, ExtraWorkingDay=6, etc.');
            $table->unsignedTinyInteger('leave_status')->comment('Draft=1, Pending=2, Approved=3, Rejected=4, Cancelled=5, Expired=6, AutoApproved=7');
            
            $table->date('start_date')->comment('Leave start date');
            $table->date('end_date')->comment('Leave end date');
            $table->decimal('total_days', 5, 2)->comment('Total leave days duration');
            
            $table->text('reason')->comment('Detailed reason for leave');
            $table->string('attachment_path', 255)->nullable()->comment('Path to supporting document');

            $table->unsignedBigInteger('approved_by')->nullable()->comment('FK to users');
            $table->timestampTz('approved_at')->nullable()->comment('Time approved');
            
            $table->unsignedBigInteger('rejected_by')->nullable()->comment('FK to users');
            $table->timestampTz('rejected_at')->nullable()->comment('Time rejected');

            $table->string('cancellation_reason', 255)->nullable()->comment('Reason for cancellation');
            
            $table->json('metadata')->nullable()->comment('For future extensibility, never core logic');

            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');

            $table->index('user_id');
            $table->index('leave_type');
            $table->index('leave_status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['user_id', 'start_date', 'end_date'], 'employee_leaves_user_id_start_date_end_date_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};
