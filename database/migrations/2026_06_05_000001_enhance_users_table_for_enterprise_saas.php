<?php

declare(strict_types=1);

use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ── New columns ──────────────────────────────────────

            $table->unsignedTinyInteger('status')
                ->default(UserStatus::ACTIVE->value)
                ->after('is_active')
                ->comment('Account lifecycle state: 1=active, 2=inactive, 3=suspended, 4=pending_verification');

            $table->timestamp('two_factor_enabled_at')
                ->nullable()
                ->after('two_factor_recovery_codes')
                ->comment('When 2FA was activated. NULL = 2FA not enabled. Replaces boolean two_factor_enabled.');

            $table->timestamp('phone_verified_at')
                ->nullable()
                ->after('phone')
                ->comment('When phone was OTP-verified. NULL = unverified. Replaces boolean phone_verified.');

            $table->timestamp('profile_completed_at')
                ->nullable()
                ->after('locale')
                ->comment('When user completed personal profile setup. NULL = incomplete. Used for progressive onboarding UI.');

            // ── Remove replaced boolean columns ──────────────────

            $table->dropColumn('two_factor_enabled');
            $table->dropColumn('phone_verified');

            // ── Indexes ──────────────────────────────────────────

            $table->index('status', 'users_status_index');
            $table->index('last_login_at', 'users_last_login_at_index');
            // deleted_at index — softDeletes already exists on the table,
            // but no explicit index was created for it in the original migration.
            $table->index('deleted_at', 'users_deleted_at_index');
        });

        // ── PostgreSQL check constraint for status values ────────
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE users ADD CONSTRAINT chk_users_status CHECK (status IN (1, 2, 3, 4))');
        }
    }

    public function down(): void
    {
        // ── Remove PostgreSQL check constraint ───────────────────
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS chk_users_status');
        }

        Schema::table('users', function (Blueprint $table) {
            // ── Drop indexes ─────────────────────────────────────
            $table->dropIndex('users_status_index');
            $table->dropIndex('users_last_login_at_index');
            $table->dropIndex('users_deleted_at_index');

            // ── Drop added columns ───────────────────────────────
            $table->dropColumn([
                'status',
                'two_factor_enabled_at',
                'phone_verified_at',
                'profile_completed_at',
            ]);

            // ── Re-add removed boolean columns ───────────────────
            $table->boolean('two_factor_enabled')
                ->default(false)
                ->after('two_factor_secret')
                ->comment('Whether 2FA is active');

            $table->boolean('phone_verified')
                ->default(false)
                ->after('phone')
                ->comment('Whether phone has been OTP-verified');
        });
    }
};
