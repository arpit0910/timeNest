<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_holidays', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');
            $table->unsignedBigInteger('organization_id')->comment('FK to organizations');
            $table->unsignedBigInteger('branch_id')->nullable()->comment('FK to branches — NULL means organization-wide');
            
            $table->string('name', 150)->comment('Holiday name, e.g. New Year Day');
            $table->date('holiday_date')->comment('Date of the holiday');
            $table->boolean('is_active')->default(true)->comment('Active/inactive flag');

            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users who created');

            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            // Unique index across active holiday dates per branch or organization wide
            $table->index(['organization_id', 'branch_id', 'holiday_date'], 'org_holidays_org_id_branch_id_date_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_holidays');
    }
};
