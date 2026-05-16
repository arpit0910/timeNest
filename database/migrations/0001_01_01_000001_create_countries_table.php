<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal auto-increment PK');
            $table->uuid('uuid')->unique()->comment('Public UUID');

            $table->string('name', 100)->comment('Country name in English');
            $table->char('iso2', 2)->unique()->comment('ISO 3166-1 alpha-2 code e.g. US, IN, GB');
            $table->char('iso3', 3)->unique()->comment('ISO 3166-1 alpha-3 code e.g. USA, IND, GBR');
            $table->string('phone_code', 10)->comment('International dialing code e.g. +1, +91');
            $table->char('currency_code', 3)->nullable()->comment('ISO 4217 currency code e.g. USD, INR');
            $table->string('currency_symbol', 10)->nullable()->comment('Currency symbol e.g. $, ₹, €');

            $table->timestamps();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
