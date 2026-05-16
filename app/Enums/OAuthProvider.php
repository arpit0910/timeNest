<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Supported OAuth provider identifiers.
 *
 * Used in social_accounts table to identify which external OAuth
 * provider a user has linked to their account.
 */
enum OAuthProvider: string
{
    case Google    = 'google';
    case Github    = 'github';
    case Microsoft = 'microsoft';

    /**
     * Get human-readable label.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::Google    => 'Google',
            self::Github    => 'GitHub',
            self::Microsoft => 'Microsoft',
        };
    }
}
