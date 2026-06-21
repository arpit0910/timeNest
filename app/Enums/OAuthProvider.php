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
    case GOOGLE = 'google';
    case GITHUB = 'github';
    case MICROSOFT = 'microsoft';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::GOOGLE => 'Google',
            self::GITHUB => 'GitHub',
            self::MICROSOFT => 'Microsoft',
        };
    }
}
