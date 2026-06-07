<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_recovery_codes')->nullable()->comment('Hashed recovery codes')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Note: Changing text back to json may fail if the text isn't valid JSON.
            // Using DB raw to bypass schema validation for down migration if needed,
            // or just rely on doctrine.
            $table->json('two_factor_recovery_codes')->nullable()->comment('Hashed recovery codes')->change();
        });
    }
};
