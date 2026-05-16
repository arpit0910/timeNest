<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('corporation_id')->comment('FK to corporations');
            $table->unsignedBigInteger('branch_id')->nullable()->comment('FK to branches — NULL means corp-wide');
            $table->unsignedBigInteger('parent_department_id')->nullable()->comment('FK self-referential for nested departments');
            $table->string('name', 150)->comment('Department name');
            $table->string('code', 30)->nullable()->comment('Short department code e.g. ENG, HR');
            $table->unsignedBigInteger('head_user_id')->nullable()->comment('user_id of department head');
            $table->boolean('is_active')->default(true)->comment('Whether department is active');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('corporation_id')->references('id')->on('corporations')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('parent_department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('head_user_id')->references('id')->on('users')->onDelete('set null');

            $table->unique(['corporation_id', 'code'], 'unique_dept_code_per_corp');
            $table->index(['corporation_id', 'is_active']);
            $table->index('branch_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
