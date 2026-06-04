<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verification_token_expires_at')
                ->nullable()
                ->after('email_verification_token')
                ->comment('When the verification token expires. NULL = no pending token.');

            $table->index('email_verification_token_expires_at', 'idx_users_verification_expires');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_verification_expires');
            $table->dropColumn('email_verification_token_expires_at');
        });
    }
};
