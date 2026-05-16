<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('corporation_id')->comment('FK to corporations');
            $table->string('name', 150)->comment('Branch name e.g. Mumbai HQ');
            $table->string('code', 30)->nullable()->comment('Short branch code e.g. MUM-HQ');
            $table->boolean('is_headquarters')->default(false)->comment('Whether this is the main/HQ branch');
            $table->string('phone', 20)->nullable()->comment('Branch contact phone in E.164');
            $table->string('email', 191)->nullable()->comment('Branch contact email');

            // Address
            $table->string('address_line_1', 255)->nullable()->comment('Street address');
            $table->string('address_line_2', 255)->nullable()->comment('Building, floor, suite');
            $table->string('city', 100)->nullable()->comment('City');
            $table->string('postal_code', 20)->nullable()->comment('Postal/pincode');
            $table->unsignedBigInteger('state_id')->nullable()->comment('FK to states');
            $table->unsignedBigInteger('country_id')->nullable()->comment('FK to countries');
            $table->decimal('latitude', 10, 8)->nullable()->comment('Geolocation latitude for geo-fencing');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Geolocation longitude for geo-fencing');
            $table->unsignedSmallInteger('geo_fence_radius')->nullable()->comment('Geo-fence radius in meters');

            $table->string('timezone', 64)->default('UTC')->comment('Branch-specific timezone');
            $table->boolean('is_active')->default(true)->comment('Whether branch is operational');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('corporation_id')->references('id')->on('corporations')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');

            $table->unique(['corporation_id', 'code'], 'unique_branch_code_per_corp');
            $table->index(['corporation_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
