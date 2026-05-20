<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Enums\SystemRole;
use App\Enums\SystemPermission;
use App\Models\Rbac\Role;
use App\Models\Rbac\Permission;

echo "\n";
echo "╔══════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                    TIME NEST - PERMISSIONS REPORT                              ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Get all system roles with permissions eager loaded
$roles = Role::where('is_system_role', true)
    ->where('guard_name', 'api')
    ->whereNull('corporation_id')
    ->orderBy('sort_order')
    ->with('permissions')
    ->get();

// Get all permissions
$allPermissions = Permission::where('guard_name', 'api')->get()->pluck('name')->toArray();

// Group permissions by module
$permissionsByModule = [];
foreach ($allPermissions as $permission) {
    $parts = explode('.', $permission);
    $module = $parts[0];
    $permissionsByModule[$module][] = $permission;
}
ksort($permissionsByModule);

// Platform Roles Report
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "PLATFORM ROLES (Global Platform Administrators)\n";
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "\n";

$platformRoles = $roles->filter(fn($r) => in_array($r->name, array_map(fn($e) => $e->value, SystemRole::platformRoles())));

foreach ($platformRoles as $role) {
    $roleEnum = SystemRole::from($role->name);
    $permissions = $role->permissions->pluck('name')->toArray();
    $hasAllPermissions = count($permissions) === count($allPermissions);
    
    echo "📋 ROLE: " . strtoupper(str_replace('_', ' ', $role->name)) . "\n";
    echo "   Description: " . $roleEnum->description() . "\n";
    echo "   Total Permissions: " . count($permissions) . " / " . count($allPermissions) . "\n";
    
    if ($hasAllPermissions) {
        echo "   ✅ HAS ALL PERMISSIONS (Wildcard Access)\n";
    } else {
        echo "   📝 Specific Permissions:\n";
        foreach ($permissionsByModule as $module => $modulePermissions) {
            $roleModulePerms = array_intersect($modulePermissions, $permissions);
            if (!empty($roleModulePerms)) {
                echo "      • $module: " . implode(', ', $roleModulePerms) . "\n";
            }
        }
    }
    echo "\n";
}

// Corporation Roles Report
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "CORPORATION ROLES (Tenant-Scoped Roles)\n";
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "\n";

$corpRoles = $roles->filter(fn($r) => in_array($r->name, array_map(fn($e) => $e->value, SystemRole::corpRoles())));

foreach ($corpRoles as $role) {
    $roleEnum = SystemRole::from($role->name);
    $permissions = $role->permissions->pluck('name')->toArray();
    $hasAllPermissions = count($permissions) === count($allPermissions);
    
    echo "📋 ROLE: " . strtoupper(str_replace('_', ' ', $role->name)) . "\n";
    echo "   Description: " . $roleEnum->description() . "\n";
    echo "   Total Permissions: " . count($permissions) . " / " . count($allPermissions) . "\n";
    
    if ($hasAllPermissions) {
        echo "   ✅ HAS ALL PERMISSIONS (Wildcard Access)\n";
    } else {
        echo "   📝 Specific Permissions:\n";
        foreach ($permissionsByModule as $module => $modulePermissions) {
            $roleModulePerms = array_intersect($modulePermissions, $permissions);
            if (!empty($roleModulePerms)) {
                echo "      • $module: " . implode(', ', $roleModulePerms) . "\n";
            }
        }
    }
    echo "\n";
}

// Detailed Comparison Matrix
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "PERMISSION MATRIX (Role vs Module)\n";
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "\n";

// Create a matrix
$matrix = [];
foreach ($roles as $role) {
    $permissions = $role->permissions->pluck('name')->toArray();
    foreach ($permissionsByModule as $module => $modulePermissions) {
        $hasModulePerm = !empty(array_intersect($modulePermissions, $permissions));
        $matrix[$role->name][$module] = $hasModulePerm ? '✓' : '-';
    }
}

// Print matrix header
$moduleHeaders = array_keys($permissionsByModule);
echo sprintf("%-25s", "Role");
foreach ($moduleHeaders as $module) {
    echo sprintf("%-12s", substr($module, 0, 12));
}
echo "\n";
echo str_repeat("-", 25 + (count($moduleHeaders) * 12)) . "\n";

// Print matrix rows
foreach ($roles as $role) {
    echo sprintf("%-25s", substr($role->name, 0, 25));
    foreach ($moduleHeaders as $module) {
        echo sprintf("%-12s", $matrix[$role->name][$module] ?? '-');
    }
    echo "\n";
}

echo "\n";

// Key Findings
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "KEY FINDINGS\n";
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "\n";

$wildcardRoles = $roles->filter(fn($r) => $r->permissions->count() === count($allPermissions));
echo "🔑 Roles with FULL ACCESS (Wildcard):\n";
foreach ($wildcardRoles as $role) {
    echo "   • " . $role->name . "\n";
}
echo "\n";

echo "📊 Permission Statistics:\n";
echo "   • Total System Roles: " . $roles->count() . "\n";
echo "   • Total Permissions: " . count($allPermissions) . "\n";
echo "   • Total Role-Permission Assignments: " . $roles->sum(fn($r) => $r->permissions->count()) . "\n";
echo "\n";

echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "REPORT GENERATED SUCCESSFULLY\n";
echo "═══════════════════════════════════════════════════════════════════════════════\n";
echo "\n";
