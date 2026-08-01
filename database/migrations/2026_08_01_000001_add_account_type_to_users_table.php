<?php

declare(strict_types=1);

use App\Enums\AccountType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('account_type')->nullable()->after('locale');
        });

        DB::table('users')->whereNull('account_type')->update([
            'account_type' => AccountType::FREELANCER->value,
        ]);

        Schema::table('users', function (Blueprint $table): void {
            $table->string('account_type')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('account_type');
        });
    }
};
