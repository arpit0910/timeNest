<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corp_memberships', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('user_id')->comment('FK to users — global identity');
            $table->unsignedBigInteger('corporation_id')->comment('FK to corporations');
            $table->unsignedBigInteger('role_id')->comment('Active role in this corporation');
            $table->unsignedBigInteger('invited_by')->nullable()->comment('user_id who sent the invitation');

            $table->string('status', 20)->default('pending')
                  ->comment('pending | active | revoked | suspended | left');
            $table->timestamp('joined_at')->nullable()->comment('When user accepted and became active');
            $table->timestamp('left_at')->nullable()->comment('When user exited the corporation');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('corporation_id')->references('id')->on('corporations')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('invited_by')->references('id')->on('users')->onDelete('set null');

            $table->unique(['user_id', 'corporation_id'], 'unique_user_per_corp');
            $table->index(['corporation_id', 'status']);
            $table->index('status');
            $table->index('role_id');
        });

        DB::statement("ALTER TABLE corp_memberships ADD CONSTRAINT chk_membership_status
            CHECK (status IN ('pending','active','revoked','suspended','left'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('corp_memberships');
    }
};
