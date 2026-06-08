<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temp_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid('jti')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('purpose', 50);
            $table->timestamp('used_at')->nullable();
            $table->timestamp('expires_at')->index();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'purpose', 'used_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_tokens');
    }
};
