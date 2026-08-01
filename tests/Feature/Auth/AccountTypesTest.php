<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Tests\TestCase;

class AccountTypesTest extends TestCase
{
    public function test_account_types_are_public_and_include_display_copy(): void
    {
        $response = $this->getJson('/api/v1/auth/account-types');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.value', 'organization')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['value', 'label', 'description'],
                ],
            ]);
    }
}
