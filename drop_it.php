<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('organization_memberships', function (Blueprint $table) {
    try { $table->dropForeign(['sub_department_id']); } catch (\Exception $e) { echo $e->getMessage(); }
    try { $table->dropColumn('sub_department_id'); } catch (\Exception $e) { echo $e->getMessage(); }
    try { $table->dropForeign(['designation_id']); } catch (\Exception $e) { echo $e->getMessage(); }
    try { $table->dropColumn('designation_id'); } catch (\Exception $e) { echo $e->getMessage(); }
});
echo "Done";
