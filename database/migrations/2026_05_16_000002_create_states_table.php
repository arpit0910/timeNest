<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal auto-increment PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->unsignedBigInteger('country_id')->comment('FK to countries');
            $table->string('name', 150)->comment('State/province name');
            $table->string('state_code', 10)->nullable()->comment('State/province code e.g. CA, MH, TX');

            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->index('country_id');
            $table->index('name');
            $table->unique(['country_id', 'state_code'], 'states_country_id_state_code_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
