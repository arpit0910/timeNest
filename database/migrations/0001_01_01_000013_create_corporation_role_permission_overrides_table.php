<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporation_role_permission_overrides', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('corporation_id')->comment('Which corporation this override belongs to');
            $table->unsignedBigInteger('role_id')->comment('Which role is being customized');
            $table->unsignedBigInteger('permission_id')->comment('Which permission is being overridden');
            $table->string('type', 10)->comment('grant = add beyond base | revoke = remove from base');
            $table->unsignedBigInteger('created_by')->comment('user_id of corp admin who made this change');

            $table->timestamps();

            $table->foreign('corporation_id', 'crpo_corp_fk')->references('id')->on('corporations')->onDelete('cascade');
            $table->foreign('role_id', 'crpo_role_fk')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id', 'crpo_perm_fk')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('created_by', 'crpo_creator_fk')->references('id')->on('users')->onDelete('restrict');

            $table->unique(['corporation_id', 'role_id', 'permission_id'], 'uniq_corp_role_perm_override');
            $table->index('corporation_id', 'crpo_corp_idx');
            $table->index(['corporation_id', 'role_id'], 'crpo_corp_role_idx');
        });

        DB::statement("ALTER TABLE corporation_role_permission_overrides
            ADD CONSTRAINT chk_override_type CHECK (type IN ('grant','revoke'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('corporation_role_permission_overrides');
    }
};
