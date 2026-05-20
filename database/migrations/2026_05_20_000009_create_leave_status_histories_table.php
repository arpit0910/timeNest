<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_status_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_leave_id');
            $table->unsignedTinyInteger('old_status')->comment('Previous status from LeaveStatusEnum');
            $table->unsignedTinyInteger('new_status')->comment('New status from LeaveStatusEnum');
            $table->unsignedBigInteger('changed_by')->comment('User who triggered the transition');
            $table->string('remarks', 255)->nullable();
            $table->json('metadata')->nullable();
            $table->timestampTz('created_at')->useCurrent();

            $table->foreign('employee_leave_id')->references('id')->on('employee_leaves')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');

            $table->index('employee_leave_id');
            $table->index('changed_by');
        });

        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->index(['user_id', 'leave_status'], 'idx_user_leave_status');
        });
    }

    public function down(): void
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->dropIndex('idx_user_leave_status');
        });

        Schema::dropIfExists('leave_status_histories');
    }
};
