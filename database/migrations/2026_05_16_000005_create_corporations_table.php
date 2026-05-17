<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Internal PK');
            $table->uuid('uuid')->unique()->comment('Public UUID used in APIs');

            // Identity
            $table->string('legal_name', 200)->comment('Full registered legal name');
            $table->string('trading_name', 200)->nullable()->comment('Brand/trading name if different from legal name');
            $table->string('slug', 100)->unique()->comment('URL-safe identifier for subdomain/URL routing');

            // Legal classification
            $table->string('legal_entity_type', 80)->nullable()->comment('Entity type: Private Limited, LLC, LLP, etc.');
            $table->string('industry', 100)->nullable()->comment('Industry sector');
            $table->string('company_size', 30)->nullable()->comment('Headcount band: 1-10, 11-50, 51-200, 201-500, 500+');

            // Generic legal identifiers
            $table->string('registration_number', 100)->nullable()->comment('Company registration number');
            $table->string('tax_id', 100)->nullable()->comment('Primary tax ID (GSTIN, EIN, VAT)');
            $table->json('legal_identifiers')->nullable()->comment('Country-specific legal identifiers as key-value JSON');

            // Contact
            $table->string('email', 191)->nullable()->comment('Primary corporate contact email');
            $table->string('phone', 20)->nullable()->comment('Corporate phone in E.164 format');
            $table->string('website', 255)->nullable()->comment('Corporate website URL');

            // Registered address
            $table->string('address_line_1', 255)->nullable()->comment('Registered office address line 1');
            $table->string('address_line_2', 255)->nullable()->comment('Address line 2');
            $table->string('city', 100)->nullable()->comment('Registered office city');
            $table->string('postal_code', 20)->nullable()->comment('Postal/zip/pincode');
            $table->unsignedBigInteger('state_id')->nullable()->comment('FK to states');
            $table->unsignedBigInteger('country_id')->nullable()->comment('FK to countries');

            // Operational address
            $table->string('operational_address_line_1', 255)->nullable()->comment('Primary operating address');
            $table->string('operational_city', 100)->nullable()->comment('Operational city');
            $table->string('operational_postal_code', 20)->nullable()->comment('Operational postal code');
            $table->unsignedBigInteger('operational_state_id')->nullable()->comment('FK to states — operational');
            $table->unsignedBigInteger('operational_country_id')->nullable()->comment('FK to countries — operational');

            // Locale & timezone
            $table->string('timezone', 64)->default('UTC')->comment('Primary operating timezone');
            $table->string('locale', 10)->default('en')->comment('Default locale');
            $table->string('currency_code', 3)->default('USD')->comment('ISO 4217 currency code');
            $table->string('date_format', 20)->default('Y-m-d')->comment('Preferred date display format');
            $table->string('week_start', 10)->default('monday')->comment('Working week start day');

            // Subscription
            $table->string('plan', 50)->default('free')->comment('Subscription plan');
            $table->timestamp('plan_expires_at')->nullable()->comment('When paid plan expires');
            $table->unsignedInteger('max_users')->default(5)->comment('User seat limit');

            // Branding
            $table->string('logo_url', 500)->nullable()->comment('Corporation logo URL');
            $table->string('brand_color_primary', 7)->nullable()->comment('Primary brand color hex');
            $table->string('brand_color_secondary', 7)->nullable()->comment('Secondary brand color hex');

            // Settings & features
            $table->json('settings')->nullable()->comment('Corp-level settings JSON');
            $table->json('feature_flags')->nullable()->comment('Per-corp feature toggle overrides');

            // State
            $table->boolean('is_active')->default(true)->comment('Whether corporation is active');
            $table->boolean('is_verified')->default(false)->comment('Whether platform has verified');
            $table->timestamp('verified_at')->nullable()->comment('Verification completion timestamp');
            $table->unsignedBigInteger('verified_by')->nullable()->comment('Platform user_id who verified');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('operational_state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('operational_country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');

            $table->index('is_active');
            $table->index('plan');
            $table->index('country_id');
            $table->index('tax_id');
            $table->index('registration_number');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE corporations ADD CONSTRAINT chk_corps_phone
                CHECK (phone IS NULL OR phone REGEXP '^\\\\+[1-9][0-9]{6,14}$')");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('corporations');
    }
};
