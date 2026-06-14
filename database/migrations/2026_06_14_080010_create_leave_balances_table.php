<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            
            $table->unsignedBigInteger('organization_id')->comment('FK to organizations cascade');
            $table->unsignedBigInteger('user_id')->comment('FK to users cascade');
            $table->unsignedBigInteger('leave_type_id')->comment('FK to leave_types cascade');
            
            $table->unsignedSmallInteger('year')->comment('Calendar year e.g. 2025');
            
            $table->decimal('allocated_days', 5, 2)->default(0)->comment('Total days allocated for this type this year including carry forward');
            $table->decimal('carry_forward_days', 5, 2)->default(0)->comment('Days carried forward from previous year');
            $table->decimal('used_days', 5, 2)->default(0)->comment('Days in Approved or AutoApproved state');
            $table->decimal('pending_days', 5, 2)->default(0)->comment('Days in Pending state awaiting approval');
            $table->decimal('remaining_days', 5, 2)->default(0)->comment('allocated_days - used_days - pending_days. May be negative if negative_balance_allowed is true.');

            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('organization_id', 'leave_balances_organization_id_foreign')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('user_id', 'leave_balances_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leave_type_id', 'leave_balances_leave_type_id_foreign')->references('id')->on('leave_types')->onDelete('cascade');

            $table->unique(['organization_id', 'user_id', 'leave_type_id', 'year'], 'leave_balances_org_user_type_year_unique');
            $table->index(['user_id', 'year']);
            $table->index(['organization_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
