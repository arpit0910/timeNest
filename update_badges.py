import re

files = [
    r'e:\timeNest\resources\views\frontend\components\layout\header.blade.php',
    r'e:\timeNest\resources\views\frontend\partials\mega-menu-panels.blade.php'
]

badge = ' <x-frontend-base.badge variant="accent" class="ml-2 px-1.5 py-0 text-[9px] uppercase tracking-wider">Upcoming</x-frontend-base.badge>'

targets = [
    "Expenses", "Projects", "Payroll", "Chat", "Docs", "Admin Panel",
    "Financial Ops", "Freelancer Mgmt", "AI Operations", "Global Compliance",
    "Enterprise Security", "Remote Teams", "Integrations", "API Docs",
    "Departments", "Teams", "Roles & Perms", "Audit Logs", "Analytics"
]
# We'll just replace the occurrences in the HTML where they are rendered as text inside spans, divs or array definitions if they are used as titles.

def update_file(path):
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()

    # For arrays like 'departments' => 'Departments'
    # we want to replace 'Departments' with 'Departments <x-...>'
    
    # We will specifically target the links in the mega menu.
    # For example: <span class="text-sm font-medium text-content group-hover:text-brand-600 transition-colors">{{ $item }}</span>
    # If $item is one of the upcoming ones, we want to append the badge.
    # Since they are rendered via loop, we can just change the array definition.
    # 'departments' => 'Departments' -> 'departments' => 'Departments' . $badge
    
    # Let's replace in mega-menu-panels:
    # 'Departments' -> 'Departments ' . '<x-frontend-base.badge variant="accent" class="ml-2 px-1.5 py-0.5 text-[9px]">Upcoming</x-frontend-base.badge>'
    
    badge_str = """' <x-frontend-base.badge variant="accent" class="ml-2 px-1.5 py-0.5 text-[9px]">Upcoming</x-frontend-base.badge>'"""
    
    replacements = {
        "'Departments'": "'Departments' . " + badge_str,
        "'Teams'": "'Teams' . " + badge_str,
        "'Roles & Perms'": "'Roles & Perms' . " + badge_str,
        "'Audit Logs'": "'Audit Logs' . " + badge_str,
        "'Analytics'": "'Analytics' . " + badge_str,
        "'Workflows'": "'Workflows' . " + badge_str,
        "'Approvals'": "'Approvals' . " + badge_str,
        "'Payroll Sync'": "'Payroll Sync' . " + badge_str,
        "'ATS'": "'ATS' . " + badge_str,
        "'Performance'": "'Performance' . " + badge_str,
    }
    
    for k, v in replacements.items():
        # only replace if not already replaced
        if k in content and v not in content:
            content = content.replace(k, v)

    # For the solutions array
    # ['slug' => 'financial-operations', 'title' => 'Financial Ops'
    # We need to change 'title' => 'Financial Ops' . $badge
    sol_replacements = {
        "'title' => 'Financial Ops'": "'title' => 'Financial Ops' . " + badge_str,
        "'title' => 'Freelancer Mgmt'": "'title' => 'Freelancer Mgmt' . " + badge_str,
        "'title' => 'AI Operations'": "'title' => 'AI Operations' . " + badge_str,
        "'title' => 'Global Compliance'": "'title' => 'Global Compliance' . " + badge_str,
        "'title' => 'Enterprise Security'": "'title' => 'Enterprise Security' . " + badge_str,
        "'title' => 'Remote Teams'": "'title' => 'Remote Teams' . " + badge_str,
        "'title' => 'Integrations'": "'title' => 'Integrations' . " + badge_str,
        "'title' => 'API Access'": "'title' => 'API Access' . " + badge_str,
    }
    for k, v in sol_replacements.items():
        if k in content and v not in content:
            content = content.replace(k, v)

    # Note that {{ $item }} and {{ $sol['title'] }} are escaped by default in Blade.
    # To render the HTML badge, they must be {!! $item !!} and {!! $sol['title'] !!}.
    content = content.replace('{{ $item }}', '{!! $item !!}')
    content = content.replace("{{ $sol['title'] }}", "{!! $sol['title'] !!}")
    
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)

for f in files:
    update_file(f)
    print(f"Updated {f}")
