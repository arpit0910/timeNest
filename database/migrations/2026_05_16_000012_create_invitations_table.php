<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('organization_id')->comment('Which organization is sending the invite');
            $table->string('email', 191)->comment('Invitee email address');
            $table->unsignedBigInteger('role_id')->comment('Role to assign on acceptance');
            $table->unsignedBigInteger('invited_by')->comment('user_id of the admin sending the invite');
            $table->string('token', 64)->unique()->comment('SHA-256 hashed secure random token');
            $table->timestamp('expires_at')->comment('Invite expiry');
            $table->timestamp('accepted_at')->nullable()->comment('When invitee accepted');
            $table->timestamp('revoked_at')->nullable()->comment('When manually revoked by admin');
            $table->unsignedBigInteger('revoked_by')->nullable()->comment('user_id who revoked');
            $table->unsignedSmallInteger('resend_count')->default(0)->comment('How many times invite was resent');
            $table->timestamp('last_resent_at')->nullable()->comment('Last resend timestamp');

            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('invited_by')->references('id')->on('users');
            $table->foreign('revoked_by')->references('id')->on('users')->onDelete('set null');

            $table->index('token');
            $table->index('email');
            $table->index(['organization_id', 'email']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
