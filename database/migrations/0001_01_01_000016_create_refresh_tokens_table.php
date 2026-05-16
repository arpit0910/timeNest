<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refresh_tokens', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('user_id')->comment('FK to users');
            $table->string('token_hash', 255)->unique()->comment('SHA-256 hash of refresh token');
            $table->string('guard', 20)->default('corp')->comment('platform | corp');
            $table->unsignedBigInteger('corporation_id')->nullable()->comment('Active corporation at issuance');
            $table->string('ip_address', 45)->nullable()->comment('IPv4 or IPv6 at issuance');
            $table->string('user_agent', 500)->nullable()->comment('User agent at issuance');
            $table->timestamp('expires_at')->comment('Token expiry — 30 days');
            $table->timestamp('revoked_at')->nullable()->comment('Set to invalidate before expiry');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('corporation_id')->references('id')->on('corporations')->onDelete('cascade');

            $table->index(['user_id', 'revoked_at']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refresh_tokens');
    }
};
