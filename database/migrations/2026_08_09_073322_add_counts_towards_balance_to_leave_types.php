<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->boolean('counts_towards_balance')
                ->default(true)
                ->after('annual_allocation_days')
                ->comment('Whether this leave type is balance-tracked at all. False for types like Unpaid Leave, which should always be submittable (subject to normal approval) regardless of allocation/negative_balance_allowed — the balance check is skipped entirely, not just relaxed.');
        });

        // Backfill existing rows: Unpaid Leave never counted towards balance in
        // intent, only in the buggy default before this fix. Every other existing
        // type keeps the column default (true).
        //
        // Code is App\Enums\Leave\LeaveType::UNPAID->value = 4. NOT 6 -- 6 is
        // EXTRA_WORKING_DAY in the current enum. An earlier pass at this feature
        // used a stale enum mapping from a doc that didn't match the real enum
        // source and got this wrong; verified directly against
        // app/Enums/Leave/LeaveType.php before writing this.
        DB::table('leave_types')
            ->where('code', '4')
            ->update(['counts_towards_balance' => false]);
    }

    public function down(): void
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropColumn('counts_towards_balance');
        });
    }
};
