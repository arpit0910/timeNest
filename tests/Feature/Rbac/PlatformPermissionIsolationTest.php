<?php

declare(strict_types=1);

namespace Tests\Feature\Rbac;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Rbac\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformPermissionIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_does_not_have_platform_full_access(): void
    {
        $role = Role::where('name', SystemRole::SUPER_ADMIN->value)
            ->whereNull('organization_id')
            ->firstOrFail();

        $this->assertFalse($role->hasPermissionTo(SystemPermission::PLATFORM_FULL_ACCESS->value));
    }
}
