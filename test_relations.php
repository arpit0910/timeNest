<?php
$profile = \App\Models\Membership\EmployeeProfile::first();
if ($profile) {
    $designation = \App\Models\Organization\Designation::first();
    $profile->designation_id = $designation->id;
    $profile->save();
}

$profile = \App\Models\Membership\EmployeeProfile::with(['designation.subDepartment.department'])->first();
dump($profile->designation->name);
dump($profile->designation->level);
dump($profile->designation->subDepartment->name);
dump($profile->designation->subDepartment->department->name);
echo "\nDONE!\n";
