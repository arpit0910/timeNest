<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_holidays', function (Blueprint $table) {
            $table->boolean('is_recurring')
                ->default(false)
                ->after('holiday_date')
                ->comment('If true, this holiday recurs annually on the same month and day regardless of year. Used for fixed national holidays.');

            $table->unsignedBigInteger('updated_by')
                ->nullable()
                ->after('created_by')
                ->comment('FK to users who last updated');

            $table->foreign('updated_by', 'organization_holidays_updated_by_foreign')
                ->references('id')->on('users')->onDelete('set null');
        });

        // Add unique constraint on [organization_id, holiday_date]
        Schema::table('organization_holidays', function (Blueprint $table) {
            $table->unique(
                ['organization_id', 'holiday_date'],
                'org_holidays_organization_id_holiday_date_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('organization_holidays', function (Blueprint $table) {
            $table->dropUnique('org_holidays_organization_id_holiday_date_unique');
            $table->dropForeign('organization_holidays_updated_by_foreign');
            $table->dropColumn(['is_recurring', 'updated_by']);
        });
    }
};
