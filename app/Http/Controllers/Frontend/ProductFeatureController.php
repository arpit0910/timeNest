<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductFeatureController extends Controller
{
    public function show($category, $slug)
    {
        $features = [
            'workforce' => [
                'attendance-management' => [
                    'title' => 'Attendance Management',
                    'categoryLabel' => 'Workforce Core',
                    'description' => 'Geofenced clock-ins, biometric integrations, and real-time shift tracking. Eliminate buddy punching and manual timesheets forever.',
                    'sections' => [
                        [
                            'title' => 'Geofenced Clock-ins',
                            'content' => 'Restrict clock-ins to specific office locations or client sites. Our advanced GPS tracking ensures employees are exactly where they need to be.',
                            'points' => ['Precision GPS tracking', 'Multiple office locations', 'Offline sync support'],
                            'component' => 'fingerprint-animation'
                        ],
                        [
                            'title' => 'Real-time Visibility',
                            'content' => 'See who is online, on break, or absent across your entire organization from a single dashboard.',
                            'points' => ['Live status board', 'Automated timesheets', 'Overtime alerts']
                        ]
                    ]
                ],
                'leave-management' => [
                    'title' => 'Leave Management',
                    'categoryLabel' => 'Workforce Core',
                    'description' => 'Automate leave policies, multi-level approvals, and holiday calendars across global teams.',
                    'sections' => [
                        [
                            'title' => 'Custom Leave Policies',
                            'content' => 'Configure complex accrual rules, carryovers, and prorations for different departments and geographical regions.',
                            'points' => ['Sick, Casual, Annual leave types', 'Automated accruals', 'Region-specific holidays']
                        ],
                        [
                            'title' => 'Smart Approvals',
                            'content' => 'Route leave requests through dynamic approval chains based on the employee\'s department or project role.',
                            'points' => ['Multi-tier approvals', 'Slack/Email notifications', 'Conflict detection']
                        ]
                    ]
                ],
                // Add default fallbacks for others
            ],
            'operations' => [
                'departments' => [
                    'title' => 'Department Management',
                    'categoryLabel' => 'Operations Hub',
                    'description' => 'Structure your organization with hierarchical departments, isolated budgets, and specific workflow rules.',
                    'sections' => [
                        [
                            'title' => 'Organizational Structure',
                            'content' => 'Build complex hierarchies that mirror your actual business. Assign managers, track departmental costs, and isolate data access.',
                            'points' => ['Unlimited nesting levels', 'Departmental budgets', 'Isolated data silos'],
                            'component' => 'gear-animation'
                        ]
                    ]
                ],
            ],
            'ai' => [
                'workforce-analyst' => [
                    'title' => 'AI Workforce Analyst',
                    'categoryLabel' => 'TimeNest AI',
                    'description' => 'An intelligent agent that constantly analyzes your workforce data to detect anomalies, burnout risks, and productivity trends.',
                    'sections' => [
                        [
                            'title' => 'Burnout Detection',
                            'content' => 'The AI monitors overtime patterns and absence frequency to proactively alert HR leaders about departments at risk of burnout.',
                            'points' => ['Predictive analytics', 'Automated HR alerts', 'Trend reporting']
                        ]
                    ]
                ]
            ]
        ];

        // Fallback for missing massive content
        $data = $features[$category][$slug] ?? [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'categoryLabel' => ucfirst($category) . ' Module',
            'description' => 'A powerful module designed to streamline your business operations and eliminate manual administrative work.',
            'sections' => [
                [
                    'title' => 'Core Capabilities',
                    'content' => 'Everything you need to manage this aspect of your business seamlessly. Automated, secure, and fully integrated with the rest of the TimeNest platform.',
                    'points' => ['Automated workflows', 'Enterprise-grade security', 'Real-time syncing']
                ],
                [
                    'title' => 'Advanced Integration',
                    'content' => 'Data from this module flows natively into your payroll, invoicing, and reporting tools. No API keys or manual exports required.',
                    'points' => ['Native payroll sync', 'Automated reporting', 'Audit trails'],
                    'component' => ($category === 'operations' ? 'gear-animation' : null)
                ]
            ]
        ];

        return view('frontend.pages.features.layout', $data);
    }
}
