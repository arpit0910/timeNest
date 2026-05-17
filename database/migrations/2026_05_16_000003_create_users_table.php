<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal auto-increment PK — used for all FK references');
            $table->uuid('uuid')->unique()->comment('Public UUID — exposed in all API routes and responses');

            // Core identity
            $table->string('name', 100)->comment('Full legal name');
            $table->string('email', 191)->unique()->comment('Global unique email — platform-level identity anchor');
            $table->string('password', 255)->nullable()->comment('Bcrypt hash. NULL if user registered via OAuth only.');
            $table->boolean('password_set')->default(false)->comment('FALSE if user has never set a password (OAuth-only users)');
            $table->timestamp('email_verified_at')->nullable()->comment('NULL = unverified. Set on email verification or Google OAuth signup.');
            $table->string('email_verification_token', 64)->nullable()->comment('Token sent in verification email');

            // Profile
            $table->string('first_name', 60)->nullable()->comment('First name (optional split from full name)');
            $table->string('last_name', 60)->nullable()->comment('Last name');
            $table->string('phone', 20)->nullable()->comment('E.164 format: +919876543210');
            $table->boolean('phone_verified')->default(false)->comment('Whether phone has been OTP-verified');
            $table->string('avatar_url', 500)->nullable()->comment('Profile photo URL');
            $table->date('date_of_birth')->nullable()->comment('User DOB');
            $table->string('gender', 20)->nullable()->comment('Gender identity');

            // Address
            $table->unsignedBigInteger('country_id')->nullable()->comment('FK to countries');
            $table->unsignedBigInteger('state_id')->nullable()->comment('FK to states');
            $table->string('city', 100)->nullable()->comment('City of residence');
            $table->string('address_line_1', 255)->nullable()->comment('Street address line 1');
            $table->string('address_line_2', 255)->nullable()->comment('Apartment, suite, building');
            $table->string('postal_code', 20)->nullable()->comment('Postal/zip/pincode');

            // Locale
            $table->string('timezone', 64)->default('UTC')->comment('IANA timezone');
            $table->string('locale', 10)->default('en')->comment('BCP 47 locale');

            // 2FA
            $table->string('two_factor_secret', 255)->nullable()->comment('TOTP secret — global across all corporations');
            $table->boolean('two_factor_enabled')->default(false)->comment('Whether 2FA is active');
            $table->json('two_factor_recovery_codes')->nullable()->comment('Hashed recovery codes');

            // Account state
            $table->boolean('is_active')->default(true)->comment('Global kill switch');
            $table->unsignedSmallInteger('token_version')->default(1)->comment('Increment to invalidate all existing JWTs');
            $table->timestamp('last_login_at')->nullable()->comment('Last successful login timestamp');
            $table->string('last_login_ip', 45)->nullable()->comment('IPv4 or IPv6 of last login');

            $table->timestamps();
            $table->softDeletes()->comment('Soft delete preserves audit trail and FK integrity');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');

            $table->index('is_active');
            $table->index('country_id');
        });

        // Password reset tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 191)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users ADD CONSTRAINT chk_users_phone
                CHECK (phone IS NULL OR phone REGEXP '^\\\\+[1-9][0-9]{6,14}$')");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
