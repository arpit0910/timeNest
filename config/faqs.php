<?php

return [
    'categories' => [
        'General' => [
            'icon' => 'sparkles',
            'description' => 'Core concepts, getting started, and overall capabilities of the platform.'
        ],
        'Organizations' => [
            'icon' => 'office-building',
            'description' => 'Workforce management, hierarchy setup, and organizational tools.'
        ],
        'Freelancers' => [
            'icon' => 'user',
            'description' => 'CRM client tracking, invoicing, and individual contractor features.'
        ],
        'Workspace' => [
            'icon' => 'users',
            'description' => 'Agency workspaces, shared billing, and collaborator tools.'
        ],
        'Attendance' => [
            'icon' => 'clock',
            'description' => 'Punch methods, geofencing, compliance regulations, and shifts.'
        ],
        'Timelogs' => [
            'icon' => 'document-text',
            'description' => 'Task logs, project mapping, and timesheet adjustments.'
        ],
        'AI' => [
            'icon' => 'cpu-chip',
            'description' => 'AI assistants, buddy-punching fraud detection, and burnout risk checks.'
        ],
        'Pricing' => [
            'icon' => 'credit-card',
            'description' => 'Transparent platform fees, seat pricing, and annual discounts.'
        ],
        'Security' => [
            'icon' => 'shield-check',
            'description' => 'Encryption, audit trails, and data residency compliance.'
        ],
        'Integrations' => [
            'icon' => 'puzzle-piece',
            'description' => 'Slack sync, calendar schedules, API access, and Zapier hooks.'
        ],
        'Onboarding' => [
            'icon' => 'rocket',
            'description' => 'Onboarding pathways, bulk importing, and training services.'
        ],
        'Enterprise' => [
            'icon' => 'briefcase',
            'description' => 'Parent-child entities, workflow builders, and custom SLAs.'
        ],
        'Future Modules' => [
            'icon' => 'light-bulb',
            'description' => 'OKRs, ATS hiring modules, and the payroll pipeline.'
        ],
    ],

    'questions' => [
        // GENERAL
        [
            'id' => 'what-makes-timenest-different',
            'category' => 'General',
            'subcategory' => 'Product Basics',
            'tags' => ['overview', 'comparison'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'What makes TimeNest different?',
            'a' => 'Unlike fragmented software stacks where HR, project management, and invoicing exist in silos, TimeNest is a unified Work Operating System. It naturally bridges the gap between organizations and independent contractors, allowing seamless workflow execution, shared workspaces, and unified financial tracking under one ecosystem powered by continuous AI monitoring.',
            'related_questions' => ['who-is-timenest-designed-for', 'how-does-timenest-scale']
        ],
        [
            'id' => 'who-is-timenest-designed-for',
            'category' => 'General',
            'subcategory' => 'Product Basics',
            'tags' => ['audience', 'startups'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Who is TimeNest designed for?',
            'a' => 'TimeNest is built for modern workforces. It serves three distinct user types: growing Organizations that need enterprise-grade HR and attendance tracking, independent Freelancers who need client management and invoicing, and Collaborative Workspaces (agencies/studios) that blend employees and freelancers on shared projects.',
            'related_questions' => ['what-makes-timenest-different', 'freelancer-to-organization']
        ],
        [
            'id' => 'freelancer-to-organization',
            'category' => 'General',
            'subcategory' => 'Account Management',
            'tags' => ['migration', 'billing'],
            'is_popular' => false,
            'label' => 'New',
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I start as a freelancer and later become an organization?',
            'a' => 'Yes. TimeNest scales with your career. You can start on the free tier to manage your individual clients. When you hire your first employee or contractor, you can seamlessly upgrade your profile to a Workspace or an Organization without migrating any of your existing client or invoice data.',
            'related_questions' => ['who-is-timenest-designed-for', 'how-does-timenest-scale']
        ],
        [
            'id' => 'manage-multiple-organizations',
            'category' => 'General',
            'subcategory' => 'Account Management',
            'tags' => ['multi-tenant', 'permissions'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I manage multiple organizations?',
            'a' => 'Yes. TimeNest supports multi-tenant management. A single user account can create, join, and switch between multiple Organizations or Workspaces, making it ideal for holding companies, serial entrepreneurs, or consultants managing operations for multiple clients.',
            'related_questions' => ['freelancer-to-organization', 'enterprise-multiple-business-units']
        ],
        [
            'id' => 'what-industries-use-timenest',
            'category' => 'General',
            'subcategory' => 'Product Basics',
            'tags' => ['industry', 'cases'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'What industries use TimeNest?',
            'a' => 'TimeNest is highly adaptable. It is currently utilized by tech startups, creative agencies, consulting firms, IT services, remote-first companies, and distributed support teams. Any industry that relies on time tracking, project delivery, and hybrid work models will find immense value in our platform.',
            'related_questions' => ['what-makes-timenest-different', 'who-is-timenest-designed-for']
        ],
        [
            'id' => 'how-does-timenest-scale',
            'category' => 'General',
            'subcategory' => 'Account Management',
            'tags' => ['infrastructure', 'scale'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'How does TimeNest scale with my company?',
            'a' => 'Our infrastructure is built on elastic cloud architecture. Whether you have 5 employees or 5,000, TimeNest automatically handles the load. As you grow, you unlock advanced enterprise features like department-level analytics, custom approval chains, API access, and dedicated success managers.',
            'related_questions' => ['what-makes-timenest-different', 'manage-multiple-organizations']
        ],

        // ORGANIZATIONS
        [
            'id' => 'employee-management',
            'category' => 'Organizations',
            'subcategory' => 'Team Management',
            'tags' => ['hr', 'onboarding'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'How does employee management work?',
            'a' => 'TimeNest provides a complete HRIS module. You can onboard employees, manage their digital files, assign them to specific shifts, track their leaves, monitor performance metrics, and handle offboarding—all from a centralized command center.',
            'related_questions' => ['organizations-departments', 'organizations-teams']
        ],
        [
            'id' => 'organizations-departments',
            'category' => 'Organizations',
            'subcategory' => 'Departments & Hierarchy',
            'tags' => ['departments', 'hierarchy'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I manage departments?',
            'a' => 'Yes. You can create complex organizational hierarchies including Departments, Sub-departments, and Teams. You can assign managers at each level, ensuring that attendance alerts, leave requests, and reports automatically route to the correct personnel.',
            'related_questions' => ['employee-management', 'organizations-teams']
        ],
        [
            'id' => 'organizations-teams',
            'category' => 'Organizations',
            'subcategory' => 'Team Management',
            'tags' => ['teams', 'projects'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Can I create teams?',
            'a' => 'Absolutely. Teams function as cross-functional units. An employee can belong to the Engineering Department but be assigned to the "Mobile App" Team. This allows for granular project tracking, team-specific shift assignments, and localized analytics.',
            'related_questions' => ['employee-management', 'organizations-departments']
        ],
        [
            'id' => 'organizations-approvals',
            'category' => 'Organizations',
            'subcategory' => 'Roles & Permissions',
            'tags' => ['workflows', 'approval'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'How do approvals work?',
            'a' => 'TimeNest features a multi-tiered workflow engine. When an employee requests leave, submits a timelog, or requests a shift change, the request automatically routes to their direct manager. Enterprise plans allow for custom, multi-step approval chains (e.g., Manager > HR > Finance).',
            'related_questions' => ['organizations-permissions', 'enterprise-workflows']
        ],
        [
            'id' => 'organizations-locations',
            'category' => 'Organizations',
            'subcategory' => 'Departments & Hierarchy',
            'tags' => ['geofencing', 'global'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'Can I manage multiple locations?',
            'a' => 'Yes. If your company operates across different offices, cities, or countries, you can set up Multiple Locations. Each location can have its own public holidays, tax rules, timezone, and GPS-fenced attendance perimeters.',
            'related_questions' => ['gps-verification', 'organizations-departments']
        ],
        [
            'id' => 'organizations-permissions',
            'category' => 'Organizations',
            'subcategory' => 'Roles & Permissions',
            'tags' => ['security', 'rbac'],
            'is_popular' => false,
            'label' => 'Updated',
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I customize workflows?',
            'a' => 'Organizations on the Pro and Enterprise plans can build custom workflows. You can define what requires approval, who approves it, automated reminders for pending actions, and customized onboarding checklists for new hires.',
            'related_questions' => ['organizations-approvals', 'enterprise-workflows']
        ],

        // FREELANCERS
        [
            'id' => 'freelancers-clients',
            'category' => 'Freelancers',
            'subcategory' => 'CRM & Client Management',
            'tags' => ['clients', 'crm'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'Can I manage clients?',
            'a' => 'Yes. The Freelancer CRM allows you to add clients, store their billing details, track project history, and monitor outstanding balances. You get a complete dashboard of your client relationships.',
            'related_questions' => ['freelancers-invoices', 'freelancers-projects']
        ],
        [
            'id' => 'freelancers-invoices',
            'category' => 'Freelancers',
            'subcategory' => 'Invoicing & Payments',
            'tags' => ['payments', 'billing'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I create invoices?',
            'a' => 'TimeNest features a professional invoicing engine. You can generate beautiful, customized invoices directly from your tracked timelogs or flat-fee milestones. It supports multiple currencies, tax rates, automated follow-ups, and direct payment integrations.',
            'related_questions' => ['freelancers-clients', 'freelancers-hours']
        ],
        [
            'id' => 'freelancers-projects',
            'category' => 'Freelancers',
            'subcategory' => 'CRM & Client Management',
            'tags' => ['kanban', 'tasks'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Can I track projects?',
            'a' => 'Yes. You can organize your work into Projects and Tasks. You can set project budgets, track your progress against deadlines, and visualize your pipeline using Kanban boards or list views.',
            'related_questions' => ['freelancers-clients', 'freelancers-hours']
        ],
        [
            'id' => 'freelancers-forecasting',
            'category' => 'Freelancers',
            'subcategory' => 'Invoicing & Payments',
            'tags' => ['ai', 'revenue'],
            'is_popular' => false,
            'label' => 'New',
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I forecast revenue?',
            'a' => 'Our AI-powered Freelancer Assistant analyzes your historical invoices, active contracts, and current timelogs to generate a reliable monthly revenue forecast, helping you manage cash flow and identify dry spells before they happen.',
            'related_questions' => ['freelancers-invoices', 'ai-revenue-forecasting']
        ],
        [
            'id' => 'freelancers-hours',
            'category' => 'Freelancers',
            'subcategory' => 'CRM & Client Management',
            'tags' => ['timesheets', 'tracker'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I track billable hours?',
            'a' => 'Yes. You can use our real-time timer or manually log hours against specific clients and tasks. TimeNest automatically distinguishes between billable and non-billable hours, ensuring you never miss invoicing for your hard work.',
            'related_questions' => ['freelancers-invoices', 'freelancers-projects']
        ],
        [
            'id' => 'freelancers-tier-free',
            'category' => 'Freelancers',
            'subcategory' => 'Invoicing & Payments',
            'tags' => ['pricing', 'free-tier'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Is the freelancer tier really free?',
            'a' => 'Yes. The core freelancer tools—client management, basic invoicing, timelogs, and task tracking—are 100% free forever. We only charge for premium capabilities like AI forecasting, white-labeling, and advanced workspaces.',
            'related_questions' => ['freelancers-hours', 'pricing-structure']
        ],

        // WORKSPACE
        [
            'id' => 'workspace-basics',
            'category' => 'Workspace',
            'subcategory' => 'Collaborators',
            'tags' => ['agency', 'collaboration'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'What is a Freelance Workspace?',
            'a' => 'A Freelance Workspace is a specialized environment where multiple independent contractors can collaborate under a single brand. It’s perfect for digital agencies, creative collectives, or ad-hoc teams assembling for a large client project.',
            'related_questions' => ['workspace-collaborators-count', 'workspace-guest-access']
        ],
        [
            'id' => 'workspace-collaborators-count',
            'category' => 'Workspace',
            'subcategory' => 'Collaborators',
            'tags' => ['team-size', 'billing'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'How many collaborators can I invite?',
            'a' => 'Workspaces can support unlimited collaborators. However, billing is based on the number of active collaborators per month. You can scale your team up and down dynamically based on project demands.',
            'related_questions' => ['workspace-basics', 'workspace-collaborator-subscriptions']
        ],
        [
            'id' => 'workspace-guest-access',
            'category' => 'Workspace',
            'subcategory' => 'Client Access',
            'tags' => ['clients', 'transparency'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can clients access workspaces?',
            'a' => 'Yes. You can invite clients as "Guests" to your workspace. They get a restricted view where they can monitor project progress, approve milestones, view timelogs, and pay invoices directly, completely transparently.',
            'related_questions' => ['workspace-basics', 'workspace-shared-billing']
        ],
        [
            'id' => 'workspace-shared-billing',
            'category' => 'Workspace',
            'subcategory' => 'Client Access',
            'tags' => ['billing', 'splits'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'How does shared billing work?',
            'a' => 'When working in a shared Workspace, the Workspace Owner handles the centralized billing to the final client. TimeNest then helps split the revenue by tracking how many billable hours each collaborator contributed to the project.',
            'related_questions' => ['workspace-guest-access', 'workspace-collaborators-together']
        ],
        [
            'id' => 'workspace-collaborators-together',
            'category' => 'Workspace',
            'subcategory' => 'Collaborators',
            'tags' => ['communication', 'files'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'Can multiple freelancers work together?',
            'a' => 'Yes. Collaborators can share project files, leave comments on tasks, track time against the same budget, and view unified reporting. It provides the structure of an agency without the overhead of a formal organization.',
            'related_questions' => ['workspace-basics', 'workspace-shared-billing']
        ],
        [
            'id' => 'workspace-collaborator-subscriptions',
            'category' => 'Workspace',
            'subcategory' => 'Collaborators',
            'tags' => ['seats', 'licensing'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Do collaborators need their own subscription?',
            'a' => 'No. If you invite a freelancer to your Workspace, the Workspace Owner pays for their seat. The freelancer can maintain their own free personal account while simultaneously accessing your paid Workspace.',
            'related_questions' => ['workspace-collaborators-count', 'workspace-basics']
        ],

        // ATTENDANCE
        [
            'id' => 'attendance-methods',
            'category' => 'Attendance',
            'subcategory' => 'Check-In & Check-Out',
            'tags' => ['hardware', 'punch'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'What attendance capture methods are supported?',
            'a' => 'TimeNest supports multiple attendance capture methods: Web Punch (Browser), Mobile App Biometrics, Kiosk Mode for shared tablets, GPS-fenced check-ins, and IP-restricted office check-ins.',
            'related_questions' => ['strict-attendance', 'gps-verification']
        ],
        [
            'id' => 'strict-attendance',
            'category' => 'Attendance',
            'subcategory' => 'Strict & Flexible Modes',
            'tags' => ['rules', 'violations'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'What is Strict Attendance?',
            'a' => 'Strict Attendance requires employees to punch in and out exactly within their scheduled shift times. Lateness, early departures, and unauthorized overtime are strictly flagged, requiring managerial approval to be added to payroll.',
            'related_questions' => ['flexible-attendance', 'hybrid-attendance']
        ],
        [
            'id' => 'flexible-attendance',
            'category' => 'Attendance',
            'subcategory' => 'Strict & Flexible Modes',
            'tags' => ['remote', 'hours'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'What is Flexible Attendance?',
            'a' => 'Flexible Attendance focuses on total hours worked rather than strict start/end times. Employees have a core window they must be present for, but can complete their required 8 hours at their own pace. Great for remote teams.',
            'related_questions' => ['strict-attendance', 'hybrid-attendance']
        ],
        [
            'id' => 'hybrid-attendance',
            'category' => 'Attendance',
            'subcategory' => 'Strict & Flexible Modes',
            'tags' => ['hybrid-work', 'shifts'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'What is Hybrid Attendance?',
            'a' => 'Hybrid Attendance allows you to mix rules. For example, an employee might have Strict Attendance on office days (Monday-Wednesday) and Flexible Attendance on remote days (Thursday-Friday).',
            'related_questions' => ['strict-attendance', 'flexible-attendance']
        ],
        [
            'id' => 'gps-verification',
            'category' => 'Attendance',
            'subcategory' => 'Geofencing & GPS',
            'tags' => ['tracking', 'geofence'],
            'is_popular' => true,
            'label' => 'Updated',
            'updated_at' => 'Updated May 2026',
            'q' => 'Can attendance be GPS verified?',
            'a' => 'Yes. For field staff or site workers, managers can set up Geofences. The employee can only punch in if their mobile device confirms they are within the designated geographic radius.',
            'related_questions' => ['attendance-methods', 'organizations-locations']
        ],
        [
            'id' => 'attendance-regularizations',
            'category' => 'Attendance',
            'subcategory' => 'Check-In & Check-Out',
            'tags' => ['regularization', 'adjustments'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can employees request adjustments?',
            'a' => 'Yes. If an employee forgets to punch in or experiences a technical issue, they can submit an "Attendance Regularization" request. This routes to their manager who can approve and correct the timesheet.',
            'related_questions' => ['attendance-methods', 'strict-attendance']
        ],
        [
            'id' => 'attendance-overtime',
            'category' => 'Attendance',
            'subcategory' => 'Overtime & Hours',
            'tags' => ['payroll', 'overtime'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Can overtime be tracked?',
            'a' => 'Yes. TimeNest automatically calculates regular hours versus overtime hours based on your organizational policies. You can set daily, weekly, or monthly overtime thresholds.',
            'related_questions' => ['strict-attendance', 'timelogs-overtime']
        ],

        // TIMELOGS
        [
            'id' => 'timelogs-basics',
            'category' => 'Timelogs',
            'subcategory' => 'Time Tracking',
            'tags' => ['tasks', 'tracking'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'What are Timelogs?',
            'a' => 'Timelogs are granular records of exactly what an employee or freelancer was working on. While Attendance tracks "When were you at work?", Timelogs track "What did you do while you were at work?"',
            'related_questions' => ['strict-timelog-mode', 'flexible-timelog-mode']
        ],
        [
            'id' => 'strict-timelog-mode',
            'category' => 'Timelogs',
            'subcategory' => 'Time Tracking',
            'tags' => ['reconciliation', 'rules'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'What is Strict Timelog Mode?',
            'a' => 'In Strict Timelog Mode, the total hours logged against tasks must match the total hours recorded in the Attendance module for that day. Any discrepancy is flagged as an anomaly.',
            'related_questions' => ['timelogs-basics', 'flexible-timelog-mode']
        ],
        [
            'id' => 'flexible-timelog-mode',
            'category' => 'Timelogs',
            'subcategory' => 'Time Tracking',
            'tags' => ['freelance', 'hours'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'What is Flexible Timelog Mode?',
            'a' => 'Flexible Timelog Mode allows users to log hours as they see fit without being strictly cross-referenced against their punch-in/punch-out times. This is the default for freelancers.',
            'related_questions' => ['timelogs-basics', 'strict-timelog-mode']
        ],
        [
            'id' => 'timelogs-approvals',
            'category' => 'Timelogs',
            'subcategory' => 'Time Tracking',
            'tags' => ['manager', 'approvals'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can managers approve worklogs?',
            'a' => 'Yes. Organizations can require managers to review and approve submitted timelogs before they are locked and sent to the billing or payroll departments.',
            'related_questions' => ['timelogs-basics', 'organizations-approvals']
        ],
        [
            'id' => 'timelogs-project-link',
            'category' => 'Timelogs',
            'subcategory' => 'Project Allocation',
            'tags' => ['projects', 'syncing'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'Can projects be linked to timelogs?',
            'a' => 'Yes. Every timelog must be attached to a specific Project, and optionally a specific Task. This ensures highly accurate project profitability reporting and resource allocation metrics.',
            'related_questions' => ['timelogs-basics', 'freelancers-projects']
        ],
        [
            'id' => 'timelogs-overtime',
            'category' => 'Timelogs',
            'subcategory' => 'Project Allocation',
            'tags' => ['overtime', 'budgets'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'How are overtime logs handled?',
            'a' => 'If a timelog pushes an employee over their standard daily hours, the system can automatically flag it. Managers can view exactly which project caused the overtime to justify the extra payroll expense.',
            'related_questions' => ['attendance-overtime', 'timelogs-basics']
        ],

        // AI
        [
            'id' => 'ai-capabilities',
            'category' => 'AI',
            'subcategory' => 'AI Assistant',
            'tags' => ['assistant', 'overview'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'What can TimeNest AI do?',
            'a' => 'TimeNest AI acts as an autonomous operational assistant. It constantly analyzes your workspace data to detect attendance anomalies, identify fraud, forecast revenue, highlight burnout risks, and automate routine administrative tasks.',
            'related_questions' => ['ai-fraud-detection', 'ai-burnout-detection']
        ],
        [
            'id' => 'ai-fraud-detection',
            'category' => 'AI',
            'subcategory' => 'Fraud Detection',
            'tags' => ['security', 'buddy-punching'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'How does AI Fraud Detection work?',
            'a' => 'Our proprietary AI models analyze login patterns, IP addresses, geolocation hops, and biometric mismatch probabilities. If an employee attempts buddy-punching or uses a VPN to spoof location, the AI instantly flags the event for review.',
            'related_questions' => ['ai-capabilities', 'security-attendance-biometrics']
        ],
        [
            'id' => 'ai-burnout-detection',
            'category' => 'AI',
            'subcategory' => 'AI Assistant',
            'tags' => ['hr', 'analytics'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'What is Workforce Analyst?',
            'a' => 'Workforce Analyst is an AI agent that monitors team health. By analyzing overtime trends, missed leaves, and timelog density, it predicts which employees are at high risk of burnout or turnover, allowing HR to intervene proactively.',
            'related_questions' => ['ai-capabilities', 'attendance-overtime']
        ],
        [
            'id' => 'ai-revenue-forecasting',
            'category' => 'AI',
            'subcategory' => 'AI Assistant',
            'tags' => ['freelancer', 'cash-flow'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'How does AI Revenue Forecasting work?',
            'a' => 'For freelancers and agencies, the AI analyzes past invoice payment speeds, active recurring contracts, and historical project profitability to project your cash flow for the next 3 to 6 months with high accuracy.',
            'related_questions' => ['freelancers-forecasting', 'ai-capabilities']
        ],
        [
            'id' => 'ai-auto-approvals',
            'category' => 'AI',
            'subcategory' => 'AI Assistant',
            'tags' => ['automations', 'approvals'],
            'is_popular' => true,
            'label' => 'New',
            'updated_at' => 'Updated May 2026',
            'q' => 'Can AI automate approvals?',
            'a' => 'Yes. You can set up "AI Auto-Approval" rules. For example, if an employee requests a leave, and the AI verifies they have sufficient balance and no conflicting team shifts, it can automatically approve the request without managerial input.',
            'related_questions' => ['organizations-approvals', 'ai-capabilities']
        ],
        [
            'id' => 'ai-privacy',
            'category' => 'AI',
            'subcategory' => 'Fraud Detection',
            'tags' => ['privacy', 'encryption'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Does AI access private data?',
            'a' => 'TimeNest AI operates strictly within your tenant boundary. We do not use your private organizational data to train our global baseline models. Your data remains completely segregated, encrypted, and secure.',
            'related_questions' => ['security-employee-protection', 'ai-capabilities']
        ],

        // PRICING
        [
            'id' => 'pricing-structure',
            'category' => 'Pricing',
            'subcategory' => 'Plans & Billing',
            'tags' => ['cost', 'billing'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'How is TimeNest priced?',
            'a' => 'We offer a transparent, module-based pricing structure. Freelancers get core features for free. Organizations pay a low monthly base platform fee, plus a small per-user fee for active employees. You only pay for the modules you use.',
            'related_questions' => ['pricing-inactive-users', 'pricing-discounts']
        ],
        [
            'id' => 'pricing-inactive-users',
            'category' => 'Pricing',
            'subcategory' => 'Plans & Billing',
            'tags' => ['seats', 'archival'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Do I pay for inactive users?',
            'a' => 'No. TimeNest only bills you for active users. If an employee leaves or a contractor is paused, you can deactivate their profile. Their data remains securely archived, but they no longer count towards your monthly bill.',
            'related_questions' => ['pricing-structure', 'pricing-upgrades']
        ],
        [
            'id' => 'pricing-setup-fees',
            'category' => 'Pricing',
            'subcategory' => 'Plans & Billing',
            'tags' => ['hidden-cost', 'enterprise'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'Are there setup or installation fees?',
            'a' => 'There are absolutely no hidden setup or installation fees for our Standard and Pro plans. Enterprise plans may include a one-time fee if custom engineering, dedicated data migration, or on-premise installation is required.',
            'related_questions' => ['pricing-structure', 'enterprise-workflows']
        ],
        [
            'id' => 'pricing-discounts',
            'category' => 'Pricing',
            'subcategory' => 'Payments',
            'tags' => ['annual', 'discount'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Do you offer annual discounts?',
            'a' => 'Yes. If you choose to bill annually rather than monthly, you receive a standard 20% discount across all plans and user seats.',
            'related_questions' => ['pricing-structure', 'pricing-methods']
        ],
        [
            'id' => 'pricing-upgrades',
            'category' => 'Pricing',
            'subcategory' => 'Plans & Billing',
            'tags' => ['downgrade', 'contract'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I upgrade or downgrade anytime?',
            'a' => 'Yes. Your business needs change, and our pricing is flexible. You can upgrade to access new modules instantly. Downgrades take effect at the start of your next billing cycle without penalty.',
            'related_questions' => ['pricing-structure', 'pricing-inactive-users']
        ],
        [
            'id' => 'pricing-methods',
            'category' => 'Pricing',
            'subcategory' => 'Payments',
            'tags' => ['stripe', 'invoice'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'What payment methods do you accept?',
            'a' => 'We accept all major credit cards (Visa, MasterCard, Amex) via Stripe. For enterprise customers on annual contracts, we also support manual invoicing, wire transfers, and ACH payments.',
            'related_questions' => ['pricing-structure', 'pricing-discounts']
        ],

        // SECURITY
        [
            'id' => 'security-employee-protection',
            'category' => 'Security',
            'subcategory' => 'Data Protection',
            'tags' => ['encryption', 'rbac'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'How is employee data protected?',
            'a' => 'Security is our foundational pillar. All data is encrypted at rest using AES-256 and in transit via TLS 1.3. We utilize strict Role-Based Access Control (RBAC) ensuring employees only see their own data, while managers only see their direct reports.',
            'related_questions' => ['security-attendance-biometrics', 'security-permissions-rbac']
        ],
        [
            'id' => 'security-attendance-biometrics',
            'category' => 'Security',
            'subcategory' => 'Data Protection',
            'tags' => ['biometrics', 'privacy'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Is attendance data encrypted?',
            'a' => 'Yes. Sensitive attendance data, particularly biometric hashes and GPS coordinates, undergo additional layers of encryption. We never store raw fingerprint or facial images, only irreversibly hashed biometric vectors.',
            'related_questions' => ['security-employee-protection', 'ai-fraud-detection']
        ],
        [
            'id' => 'security-audit-logs',
            'category' => 'Security',
            'subcategory' => 'Compliance & Auditing',
            'tags' => ['immutable', 'logs'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Are audit logs available?',
            'a' => 'Yes. Every significant action taken in the platform—from a shift change to a payroll export—is permanently recorded in an immutable Audit Log, complete with user ID, timestamp, IP address, and action details.',
            'related_questions' => ['security-employee-protection', 'security-compliance-gdpr']
        ],
        [
            'id' => 'security-permissions-rbac',
            'category' => 'Security',
            'subcategory' => 'Data Protection',
            'tags' => ['roles', 'permissions'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'How are permissions managed?',
            'a' => 'TimeNest provides an advanced RBAC engine. You can use our default roles (Employee, Manager, HR, Admin) or create Custom Roles with granular permission checkboxes for exactly what a user can view, edit, or delete.',
            'related_questions' => ['organizations-permissions', 'security-employee-protection']
        ],
        [
            'id' => 'security-compliance-gdpr',
            'category' => 'Security',
            'subcategory' => 'Compliance & Auditing',
            'tags' => ['gdpr', 'soc2'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'What compliance standards are supported?',
            'a' => 'Our infrastructure is designed to be SOC2 Type II compliant. We offer extensive tools for GDPR compliance, including Right to Forget (data anonymization) and strict data residency options for enterprise clients.',
            'related_questions' => ['security-audit-logs', 'security-employee-protection']
        ],
        [
            'id' => 'security-audits-testing',
            'category' => 'Security',
            'subcategory' => 'Compliance & Auditing',
            'tags' => ['pentesting', 'external'],
            'is_popular' => false,
            'label' => 'Updated',
            'updated_at' => 'Updated May 2026',
            'q' => 'Do you perform security audits?',
            'a' => 'Yes. We contract independent third-party cybersecurity firms to perform rigorous penetration testing and vulnerability assessments on our platform twice a year. Executive summaries of these reports are available under NDA.',
            'related_questions' => ['security-employee-protection', 'security-compliance-gdpr']
        ],

        // INTEGRATIONS
        [
            'id' => 'integrations-slack',
            'category' => 'Integrations',
            'subcategory' => 'SaaS Apps (Slack, Google)',
            'tags' => ['slack-bot', 'punch'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'Does TimeNest integrate with Slack?',
            'a' => 'Yes. Our Slack integration allows employees to punch in/out, request leaves, and receive approval notifications directly within Slack. Managers can approve requests directly from their Slack channels.',
            'related_questions' => ['integrations-google-calendar', 'integrations-zapier']
        ],
        [
            'id' => 'integrations-google-calendar',
            'category' => 'Integrations',
            'subcategory' => 'SaaS Apps (Slack, Google)',
            'tags' => ['calendar', 'gcal'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Can I sync with Google Workspace?',
            'a' => 'Yes. You can sync your organization’s users via Google Directory. Furthermore, approved leaves and shifts automatically sync to employees’ Google Calendars, and Google Meet links can be auto-generated for tasks.',
            'related_questions' => ['integrations-slack', 'integrations-zapier']
        ],
        [
            'id' => 'integrations-payroll',
            'category' => 'Integrations',
            'subcategory' => 'SaaS Apps (Slack, Google)',
            'tags' => ['payroll-sync', 'gusto'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Do you integrate with payroll providers?',
            'a' => 'Yes. While TimeNest tracks the exact hours and calculates the gross pay, we integrate seamlessly with major payroll providers like Gusto, Deel, and RazorpayX to automate the final monetary disbursements.',
            'related_questions' => ['future-payroll-module', 'integrations-slack']
        ],
        [
            'id' => 'integrations-api',
            'category' => 'Integrations',
            'subcategory' => 'API & Zapier',
            'tags' => ['rest-api', 'developers'],
            'is_popular' => true,
            'label' => 'New',
            'updated_at' => 'Updated May 2026',
            'q' => 'Is there an open API?',
            'a' => 'Yes. We provide a comprehensive, developer-friendly REST API for our Pro and Enterprise customers. You can programmatically access your attendance, user, and project data to build custom internal tools.',
            'related_questions' => ['integrations-zapier', 'integrations-sso']
        ],
        [
            'id' => 'integrations-zapier',
            'category' => 'Integrations',
            'subcategory' => 'API & Zapier',
            'tags' => ['zapier', 'automations'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Do you support Zapier or Make?',
            'a' => 'Yes. TimeNest has official apps on both Zapier and Make (formerly Integromat), allowing you to connect TimeNest to over 5,000 other SaaS applications without writing a single line of code.',
            'related_questions' => ['integrations-api', 'integrations-slack']
        ],
        [
            'id' => 'integrations-sso',
            'category' => 'Integrations',
            'subcategory' => 'API & Zapier',
            'tags' => ['saml', 'okta'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I use Single Sign-On (SSO)?',
            'a' => 'Yes. Enterprise customers can enforce SAML-based Single Sign-On (SSO) utilizing providers like Okta, Azure AD, Google Workspace, or OneLogin, ensuring maximum corporate security compliance.',
            'related_questions' => ['integrations-api', 'security-permissions-rbac']
        ],

        // ONBOARDING
        [
            'id' => 'onboarding-setup-speed',
            'category' => 'Onboarding',
            'subcategory' => 'Setup & Imports',
            'tags' => ['wizard', 'setup'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'How long does setup take?',
            'a' => 'Setting up a basic organization takes less than 15 minutes. Our guided wizard helps you establish departments, set default attendance rules, and invite your first team members immediately.',
            'related_questions' => ['onboarding-csv-import', 'onboarding-spreadsheets']
        ],
        [
            'id' => 'onboarding-csv-import',
            'category' => 'Onboarding',
            'subcategory' => 'Setup & Imports',
            'tags' => ['csv', 'bulk-import'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Can I import employees?',
            'a' => 'Yes. You can effortlessly bulk import your entire workforce using our standardized CSV templates. TimeNest automatically parses the data, creates the accounts, and sends welcome emails.',
            'related_questions' => ['onboarding-setup-speed', 'onboarding-spreadsheets']
        ],
        [
            'id' => 'onboarding-historical-data',
            'category' => 'Onboarding',
            'subcategory' => 'Setup & Imports',
            'tags' => ['migration', 'history'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I import existing attendance data?',
            'a' => 'Yes. If you are migrating mid-year, you can import historical attendance records, past timelogs, and existing leave balances to ensure continuous tracking without losing operational history.',
            'related_questions' => ['onboarding-csv-import', 'onboarding-spreadsheets']
        ],
        [
            'id' => 'onboarding-spreadsheets',
            'category' => 'Onboarding',
            'subcategory' => 'Setup & Imports',
            'tags' => ['excel', 'sheets'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can I migrate from spreadsheets?',
            'a' => 'Absolutely. Many of our customers graduate from messy Excel sheets to TimeNest. Our import tools are specifically designed to accept raw data exports from spreadsheets and map them to our relational database.',
            'related_questions' => ['onboarding-csv-import', 'onboarding-historical-data']
        ],
        [
            'id' => 'onboarding-training',
            'category' => 'Onboarding',
            'subcategory' => 'Training & Support',
            'tags' => ['tutorials', 'webinars'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Can my team receive training?',
            'a' => 'Yes. We offer extensive documentation, video tutorials, and interactive in-app walkthroughs. For enterprise clients, we provide dedicated live training webinars for your HR staff and management teams.',
            'related_questions' => ['onboarding-setup-speed', 'onboarding-success-managers']
        ],
        [
            'id' => 'onboarding-success-managers',
            'category' => 'Onboarding',
            'subcategory' => 'Training & Support',
            'tags' => ['account-manager', 'vip-support'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Is there a dedicated success manager?',
            'a' => 'Customers on our Enterprise plans are assigned a dedicated Customer Success Manager. They act as your internal advocate, ensuring your rollout is smooth and your organization maximizes the value of the platform.',
            'related_questions' => ['onboarding-training', 'pricing-setup-fees']
        ],

        // ENTERPRISE
        [
            'id' => 'enterprise-workflows',
            'category' => 'Enterprise',
            'subcategory' => 'Custom Workflows',
            'tags' => ['automations', 'workflow-builder'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'Do you support custom workflows?',
            'a' => 'Yes. Enterprise customers gain access to our visual Workflow Builder. You can create complex, condition-based automation chains tailored precisely to your internal corporate policies and legal requirements.',
            'related_questions' => ['organizations-approvals', 'enterprise-custom-approval-chains']
        ],
        [
            'id' => 'enterprise-multiple-business-units',
            'category' => 'Enterprise',
            'subcategory' => 'Multi-Entity Management',
            'tags' => ['subsidiaries', 'holding'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Can we manage multiple business units?',
            'a' => 'Yes. TimeNest Enterprise supports complex parent-child entity structures. You can manage multiple subsidiaries, holding companies, or distinct brands under one unified master dashboard with segregated billing.',
            'related_questions' => ['manage-multiple-organizations', 'enterprise-custom-reporting']
        ],
        [
            'id' => 'enterprise-custom-approval-chains',
            'category' => 'Enterprise',
            'subcategory' => 'Custom Workflows',
            'tags' => ['approvals', 'tiering'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Can we customize approval chains?',
            'a' => 'Yes. You can define multi-tiered approval chains based on variables. For example, a 1-day leave may require direct manager approval, but a 14-day leave might require approval from the manager, HR head, and department VP.',
            'related_questions' => ['enterprise-workflows', 'organizations-approvals']
        ],
        [
            'id' => 'enterprise-hosting',
            'category' => 'Enterprise',
            'subcategory' => 'Multi-Entity Management',
            'tags' => ['on-prem', 'cloud-hosting'],
            'is_popular' => false,
            'label' => 'Updated',
            'updated_at' => 'Updated May 2026',
            'q' => 'Do you offer on-premise hosting?',
            'a' => 'Currently, TimeNest is exclusively a cloud-hosted SaaS platform. However, for large enterprise clients with strict compliance requirements, we offer dedicated single-tenant cloud hosting options.',
            'related_questions' => ['security-compliance-gdpr', 'enterprise-sla']
        ],
        [
            'id' => 'enterprise-custom-reporting',
            'category' => 'Enterprise',
            'subcategory' => 'Multi-Entity Management',
            'tags' => ['sql', 'analytics'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'Can we get custom reporting?',
            'a' => 'Yes. While TimeNest includes dozens of pre-built reports, Enterprise clients can use our Advanced SQL Report Builder or request our engineering team to construct bespoke analytics dashboards tailored to their KPIs.',
            'related_questions' => ['enterprise-multiple-business-units', 'ai-capabilities']
        ],
        [
            'id' => 'enterprise-sla',
            'category' => 'Enterprise',
            'subcategory' => 'Multi-Entity Management',
            'tags' => ['guarantee', 'uptime'],
            'is_popular' => true,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'What is the SLA guarantee?',
            'a' => 'We offer a financially-backed 99.99% Service Level Agreement (SLA) uptime guarantee for Enterprise customers, ensuring your critical workforce infrastructure is always available when you need it.',
            'related_questions' => ['enterprise-hosting', 'security-compliance-gdpr']
        ],

        // FUTURE MODULES
        [
            'id' => 'future-roadmap',
            'category' => 'Future Modules',
            'subcategory' => 'Roadmap & Releases',
            'tags' => ['updates', 'features'],
            'is_popular' => true,
            'label' => 'Popular',
            'updated_at' => 'Updated May 2026',
            'q' => 'What is on the roadmap?',
            'a' => 'Our engineering team ships new features weekly. Major upcoming modules include an integrated Applicant Tracking System (ATS) for recruitment, automated Payroll generation, and an advanced OKR/Performance Management suite.',
            'related_questions' => ['future-payroll-module', 'future-ai-advancements']
        ],
        [
            'id' => 'future-new-features-pricing',
            'category' => 'Future Modules',
            'subcategory' => 'Roadmap & Releases',
            'tags' => ['subscription', 'upgrades'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'Will current users get new features?',
            'a' => 'Yes. Most new features and incremental improvements are automatically rolled out to all users on active plans. Major new foundational modules (like Payroll) will be offered as optional add-ons.',
            'related_questions' => ['future-roadmap', 'pricing-upgrades']
        ],
        [
            'id' => 'future-feature-requests',
            'category' => 'Future Modules',
            'subcategory' => 'Roadmap & Releases',
            'tags' => ['feedback', 'community'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated March 2026',
            'q' => 'Can we request features?',
            'a' => 'Absolutely. We actively shape our roadmap based on customer feedback. Users can submit feature requests through our community portal, and our product team regularly interviews power users for deep insights.',
            'related_questions' => ['future-roadmap', 'future-new-features-pricing']
        ],
        [
            'id' => 'future-payroll-module',
            'category' => 'Future Modules',
            'subcategory' => 'Beta Testing',
            'tags' => ['payroll', 'beta'],
            'is_popular' => true,
            'label' => 'New',
            'updated_at' => 'Updated May 2026',
            'q' => 'When is the Payroll module launching?',
            'a' => 'The integrated Payroll module is currently in private beta with select enterprise customers. We anticipate a public rollout for Indian and US markets by Q4 of this year.',
            'related_questions' => ['future-roadmap', 'integrations-payroll']
        ],
        [
            'id' => 'future-ai-advancements',
            'category' => 'Future Modules',
            'subcategory' => 'Beta Testing',
            'tags' => ['ai', 'predictions'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated May 2026',
            'q' => 'Are more AI features coming?',
            'a' => 'Yes. We are heavily investing in AI. Upcoming features include an AI-powered recruitment screener, natural language schedule generation ("Schedule John for mornings next week"), and predictive project risk analysis.',
            'related_questions' => ['ai-capabilities', 'future-roadmap']
        ],
        [
            'id' => 'future-mobile-app',
            'category' => 'Future Modules',
            'subcategory' => 'Roadmap & Releases',
            'tags' => ['ios', 'android'],
            'is_popular' => false,
            'label' => null,
            'updated_at' => 'Updated April 2026',
            'q' => 'How often is the mobile app updated?',
            'a' => 'The iOS and Android mobile applications receive updates simultaneously with our web platform. We deploy minor patches bi-weekly and major feature updates on a 6-week release cycle.',
            'related_questions' => ['future-roadmap', 'attendance-methods']
        ],
    ]
];
