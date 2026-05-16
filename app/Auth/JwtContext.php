<?php

declare(strict_types=1);

namespace App\Auth;

use App\Enums\Guard;

/**
 * Immutable DTO holding parsed JWT claims.
 *
 * Bound to the container as a singleton during each request lifecycle
 * by JwtAuthenticate middleware. Provides type-safe access to authorization
 * context without relying on dynamic request properties or magic strings.
 *
 * @see \App\Http\Middleware\JwtAuthenticate
 */
final readonly class JwtContext
{
    private function __construct(
        public Guard   $guard,
        public ?int    $corporationId,
        public ?string $corporationUuid,
        public ?string $role,
        public ?string $purpose,
        public string  $userUuid,
        public int     $tokenVersion,
    ) {}

    /**
     * Create from raw JWT payload claims.
     *
     * @param array<string, mixed> $claims
     */
    public static function fromPayload(array $claims): self
    {
        return new self(
            guard: Guard::tryFrom($claims['guard'] ?? '') ?? Guard::Temp,
            corporationId: isset($claims['corporation_id']) ? (int) $claims['corporation_id'] : null,
            corporationUuid: $claims['corporation_uuid'] ?? null,
            role: $claims['role'] ?? null,
            purpose: $claims['purpose'] ?? null,
            userUuid: $claims['user_uuid'] ?? '',
            tokenVersion: (int) ($claims['token_version'] ?? 0),
        );
    }

    /**
     * Check if current context is platform-level.
     */
    public function isPlatform(): bool
    {
        return $this->guard->isPlatform();
    }

    /**
     * Check if current context is corporation-level.
     */
    public function isCorp(): bool
    {
        return $this->guard->isCorp();
    }

    /**
     * Check if current context is a temporary token.
     */
    public function isTemp(): bool
    {
        return $this->guard->isTemp();
    }

    /**
     * Check if a corporation context is available.
     */
    public function hasCorporationContext(): bool
    {
        return $this->corporationId !== null;
    }
}
