<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_memberships', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('user_id')->comment('FK to users');
            $table->string('status', 20)->default('active')->comment('active | revoked');
            $table->unsignedBigInteger('granted_by')->nullable()->comment('user_id who granted platform access');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('granted_by')->references('id')->on('users')->onDelete('set null');

            $table->unique('user_id')->comment('One platform role per user');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_memberships');
    }
};
