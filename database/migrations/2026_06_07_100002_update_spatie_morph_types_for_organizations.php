<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $updates = [
            'App\Models\Corporation\Corporation' => 'App\Models\Organization\Organization',
            'App\Models\Membership\CorpMembership' => 'App\Models\Organization\OrganizationMembership',
            'App\Models\Auth\SocialAccount' => 'App\Models\Auth\OAuthAccount',
            'App\Models\Attendance\AttendanceWorklogPolicy' => 'App\Models\Attendance\WorklogPolicy',
        ];

        foreach ($updates as $old => $new) {
            DB::table('model_has_roles')->where('model_type', $old)->update(['model_type' => $new]);
            DB::table('model_has_permissions')->where('model_type', $old)->update(['model_type' => $new]);
        }
    }

    public function down(): void
    {
        $reverses = [
            'App\Models\Organization\Organization' => 'App\Models\Corporation\Corporation',
            'App\Models\Organization\OrganizationMembership' => 'App\Models\Membership\CorpMembership',
            'App\Models\Auth\OAuthAccount' => 'App\Models\Auth\SocialAccount',
            'App\Models\Attendance\WorklogPolicy' => 'App\Models\Attendance\AttendanceWorklogPolicy',
        ];

        foreach ($reverses as $old => $new) {
            DB::table('model_has_roles')->where('model_type', $old)->update(['model_type' => $new]);
            DB::table('model_has_permissions')->where('model_type', $old)->update(['model_type' => $new]);
        }
    }
};
