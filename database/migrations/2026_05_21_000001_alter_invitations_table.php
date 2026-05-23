<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
     {
         // 1. Drop foreign key constraint on original table
         Schema::table('invitations', function (Blueprint $table) {
             $table->dropForeign(['invited_by']);
         });

         // 2. Rename the table
         Schema::rename('invitations', 'corporation_invitations');

         // 3. Alter table structure
         Schema::table('corporation_invitations', function (Blueprint $table) {
             $table->renameColumn('invited_by', 'invited_by_user_id');
             $table->unsignedTinyInteger('status')->default(1)->after('token')->comment('InvitationStatusEnum');
             $table->json('metadata')->nullable()->after('last_resent_at');
         });

         // 4. Re-add foreign key constraint
         Schema::table('corporation_invitations', function (Blueprint $table) {
             $table->foreign('invited_by_user_id')->references('id')->on('users')->onDelete('cascade');
         });
     }

     /**
      * Reverse the migrations.
      */
     public function down(): void
     {
         Schema::table('corporation_invitations', function (Blueprint $table) {
             $table->dropForeign(['invited_by_user_id']);
         });

         Schema::table('corporation_invitations', function (Blueprint $table) {
             $table->renameColumn('invited_by_user_id', 'invited_by');
             $table->dropColumn(['status', 'metadata']);
         });

         Schema::rename('corporation_invitations', 'invitations');

         Schema::table('invitations', function (Blueprint $table) {
             $table->foreign('invited_by')->references('id')->on('users')->onDelete('cascade');
         });
     }
};
