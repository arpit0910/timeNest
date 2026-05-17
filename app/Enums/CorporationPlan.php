<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Subscription plan tiers for corporations.
 *
 * Each plan tier unlocks different feature sets and seat limits.
 */
enum CorporationPlan: string
{
    case Free = 'free';
    case Starter = 'starter';
    case Professional = 'professional';
    case Enterprise = 'enterprise';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Free => 'Free',
            self::Starter => 'Starter',
            self::Professional => 'Professional',
            self::Enterprise => 'Enterprise',
        };
    }

    /**
     * Get default user seat limit for the plan.
     */
    public function defaultMaxUsers(): int
    {
        return match ($this) {
            self::Free => 5,
            self::Starter => 25,
            self::Professional => 100,
            self::Enterprise => 500,
        };
    }
}
