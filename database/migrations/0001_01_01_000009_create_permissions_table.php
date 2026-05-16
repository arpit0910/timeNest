<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->string('name', 100)->unique()->comment('Dot-notation: {module}.{action}');
            $table->string('module', 50)->comment('Feature module: attendance|users|payroll|etc.');
            $table->string('action', 50)->comment('Action: view|create|edit|delete|export|approve|manage');
            $table->text('description')->nullable()->comment('What this permission grants');
            $table->boolean('is_active')->default(true)->comment('Inactive permissions excluded from resolution');

            $table->timestamps();

            $table->index('module');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
