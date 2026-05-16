<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('user_id')->comment('FK to users — the linked global identity');
            $table->string('provider', 30)->comment('OAuth provider name: google | github | microsoft');
            $table->string('provider_id', 255)->comment('Provider unique user ID');
            $table->string('provider_email', 191)->nullable()->comment('Email returned by provider');
            $table->string('provider_name', 150)->nullable()->comment('Display name from provider');
            $table->string('provider_avatar', 500)->nullable()->comment('Avatar URL from provider');
            $table->text('access_token')->nullable()->comment('Provider access token — encrypted at rest');
            $table->text('refresh_token')->nullable()->comment('Provider refresh token — encrypted at rest');
            $table->timestamp('token_expires_at')->nullable()->comment('Provider access token expiry');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['provider', 'provider_id'], 'unique_provider_account');
            $table->index('user_id');
            $table->index('provider_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
