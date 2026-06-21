<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Subscription plan tiers for organizations.
 *
 * Each plan tier unlocks different feature sets and seat limits.
 */
enum OrganizationPlan: string
{
    case FREE = 'free';
    case STARTER = 'starter';
    case PROFESSIONAL = 'professional';
    case ENTERPRISE = 'enterprise';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::FREE => 'Free',
            self::STARTER => 'Starter',
            self::PROFESSIONAL => 'Professional',
            self::ENTERPRISE => 'Enterprise',
        };
    }

    /**
     * Get default user seat limit for the plan.
     */
    public function defaultMaxUsers(): int
    {
        return match ($this) {
            self::FREE => 5,
            self::STARTER => 25,
            self::PROFESSIONAL => 100,
            self::ENTERPRISE => 500,
        };
    }
}
