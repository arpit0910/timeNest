<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Organization\Department;
use App\Models\Organization\Designation;
use App\Models\Organization\SubDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GlobalDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $structure = [
            'Technology' => [
                'desc' => 'Technology and Engineering division',
                'sub' => [
                    'Frontend Development' => [
                        ['Junior Frontend Developer', 1],
                        ['Frontend Developer', 2],
                        ['Senior Frontend Developer', 3],
                        ['Lead Frontend Developer', 4],
                        ['Principal Frontend Engineer', 5],
                    ],
                    'Backend Development' => [
                        ['Junior Backend Developer', 1],
                        ['Backend Developer', 2],
                        ['Senior Backend Developer', 3],
                        ['Lead Backend Developer', 4],
                        ['Principal Backend Engineer', 5],
                    ],
                    'DevOps & Infrastructure' => [
                        ['Junior DevOps Engineer', 1],
                        ['DevOps Engineer', 2],
                        ['Senior DevOps Engineer', 3],
                        ['Lead DevOps Engineer', 4],
                    ],
                    'Quality Assurance' => [
                        ['Junior QA Engineer', 1],
                        ['QA Engineer', 2],
                        ['Senior QA Engineer', 3],
                        ['QA Lead', 4],
                    ],
                    'Mobile Development' => [
                        ['Junior Mobile Developer', 1],
                        ['Mobile Developer', 2],
                        ['Senior Mobile Developer', 3],
                        ['Lead Mobile Developer', 4],
                    ],
                ]
            ],
            'Human Resources' => [
                'desc' => 'Human Resources and People Operations',
                'sub' => [
                    'Talent Acquisition' => [
                        ['HR Trainee', 1],
                        ['HR Executive', 2],
                        ['Senior HR Executive', 3],
                        ['Talent Acquisition Lead', 4],
                    ],
                    'People Operations' => [
                        ['HR Associate', 1],
                        ['HR Generalist', 2],
                        ['Senior HR Generalist', 3],
                        ['HR Manager', 4],
                        ['HR Director', 5],
                    ],
                ]
            ],
            'Finance' => [
                'desc' => 'Finance and Accounting',
                'sub' => [
                    'Accounting' => [
                        ['Accounts Trainee', 1],
                        ['Accounts Executive', 2],
                        ['Senior Accounts Executive', 3],
                        ['Accounts Manager', 4],
                    ],
                    'Financial Planning' => [
                        ['Finance Analyst', 2],
                        ['Senior Finance Analyst', 3],
                        ['Finance Manager', 4],
                        ['Finance Director', 5],
                    ],
                ]
            ],
            'Sales & Marketing' => [
                'desc' => 'Sales and Marketing',
                'sub' => [
                    'Sales' => [
                        ['Sales Trainee', 1],
                        ['Sales Executive', 2],
                        ['Senior Sales Executive', 3],
                        ['Sales Manager', 4],
                        ['Sales Director', 5],
                    ],
                    'Marketing' => [
                        ['Marketing Trainee', 1],
                        ['Marketing Executive', 2],
                        ['Senior Marketing Executive', 3],
                        ['Marketing Manager', 4],
                    ],
                ]
            ],
            'Operations' => [
                'desc' => 'Company Operations',
                'sub' => [
                    'General Operations' => [
                        ['Operations Associate', 1],
                        ['Operations Executive', 2],
                        ['Senior Operations Executive', 3],
                        ['Operations Manager', 4],
                        ['Operations Director', 5],
                    ],
                ]
            ],
            'Product & Design' => [
                'desc' => 'Product Management and Design',
                'sub' => [
                    'Product Management' => [
                        ['Associate Product Manager', 1],
                        ['Product Manager', 2],
                        ['Senior Product Manager', 3],
                        ['Principal Product Manager', 4],
                        ['VP of Product', 5],
                    ],
                    'UI/UX Design' => [
                        ['Junior Designer', 1],
                        ['UI/UX Designer', 2],
                        ['Senior UI/UX Designer', 3],
                        ['Lead Designer', 4],
                    ],
                ]
            ],
            'Customer Support' => [
                'desc' => 'Customer Support and Success',
                'sub' => [
                    'Support Operations' => [
                        ['Support Trainee', 1],
                        ['Support Executive', 2],
                        ['Senior Support Executive', 3],
                        ['Support Team Lead', 4],
                        ['Support Manager', 5],
                    ],
                ]
            ],
        ];

        foreach ($structure as $deptName => $deptData) {
            $dept = Department::updateOrCreate(
                ['slug' => Str::slug($deptName), 'organization_id' => null],
                [
                    'name'        => $deptName,
                    'description' => $deptData['desc'],
                    'is_active'   => true,
                ]
            );

            foreach ($deptData['sub'] as $subName => $designations) {
                $subDept = SubDepartment::updateOrCreate(
                    [
                        'slug'            => Str::slug($subName),
                        'department_id'   => $dept->id,
                        'organization_id' => null,
                    ],
                    [
                        // model boots uuid
                        'name'      => $subName,
                        'is_active' => true,
                    ]
                );

                foreach ($designations as $desig) {
                    Designation::updateOrCreate(
                        [
                            'slug'              => Str::slug($desig[0]),
                            'sub_department_id' => $subDept->id,
                            'organization_id'   => null,
                        ],
                        [
                            // model boots uuid
                            'name'      => $desig[0],
                            'level'     => $desig[1],
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
    }
}
