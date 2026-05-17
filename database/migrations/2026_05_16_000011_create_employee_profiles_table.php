<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('user_id')->comment('FK to users — the person');
            $table->unsignedBigInteger('corporation_id')->comment('FK to corporations — their employer');
            $table->unsignedBigInteger('corp_membership_id')->comment('FK to corp_memberships');

            // Employment identity
            $table->string('employee_code', 50)->nullable()->comment('Corp-assigned employee ID');
            $table->string('designation', 100)->nullable()->comment('Job title/designation');
            $table->unsignedBigInteger('department_id')->nullable()->comment('FK to departments');
            $table->unsignedBigInteger('branch_id')->nullable()->comment('FK to branches');
            $table->unsignedBigInteger('reports_to')->nullable()->comment('user_id of direct manager');

            // Employment terms
            $table->string('employment_type', 30)->nullable()
                ->comment('full_time | part_time | contractor | intern | probation | consultant');
            $table->date('joining_date')->nullable()->comment('Official joining date');
            $table->date('confirmation_date')->nullable()->comment('Probation end / confirmation date');
            $table->date('exit_date')->nullable()->comment('Last working day');
            $table->string('exit_reason', 255)->nullable()->comment('Reason for separation');

            // Work location
            $table->string('work_location', 255)->nullable()->comment('Physical work location');

            // Professional profile
            $table->text('bio')->nullable()->comment('Professional bio');
            $table->string('linkedin_url', 255)->nullable()->comment('LinkedIn profile URL');
            $table->string('emergency_contact_name', 100)->nullable()->comment('Emergency contact name');
            $table->string('emergency_contact_phone', 20)->nullable()->comment('Emergency contact phone E.164');
            $table->string('emergency_contact_relation', 50)->nullable()->comment('Relationship');

            // Status
            $table->boolean('is_active')->default(true)->comment('Whether employment is active');

            // Documents
            $table->json('documents')->nullable()->comment('JSON array of document references');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('corporation_id')->references('id')->on('corporations')->onDelete('cascade');
            $table->foreign('corp_membership_id')->references('id')->on('corp_memberships')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('reports_to')->references('id')->on('users')->onDelete('set null');

            $table->unique(['user_id', 'corporation_id'], 'unique_employee_per_corp');
            $table->index(['corporation_id', 'is_active']);
            $table->index('department_id');
            $table->index('branch_id');
            $table->index('employee_code');
            $table->index('joining_date');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE employee_profiles ADD CONSTRAINT chk_emp_employment_type
                CHECK (employment_type IN ('full_time','part_time','contractor','intern','probation','consultant'))");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};
