<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_memberships', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('user_id')->comment('FK to users — global identity');
            $table->unsignedBigInteger('organization_id')->comment('FK to organizations');
            $table->unsignedBigInteger('invited_by')->nullable()->comment('user_id who sent the invitation');

            $table->string('status', 20)->default('pending')
                ->comment('pending | active | revoked | suspended | left');
            $table->timestamp('joined_at')->nullable()->comment('When user accepted and became active');
            $table->timestamp('left_at')->nullable()->comment('When user exited the organization');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('invited_by')->references('id')->on('users')->onDelete('set null');

            $table->unique(['user_id', 'organization_id'], 'organization_memberships_user_id_organization_id_unique');
            $table->index(['organization_id', 'status']);
            $table->index('status');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE organization_memberships ADD CONSTRAINT chk_membership_status
                CHECK (status IN ('pending','active','revoked','suspended','left'))");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_memberships');
    }
};
