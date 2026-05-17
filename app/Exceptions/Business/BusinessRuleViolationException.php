<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * BusinessRuleViolationException — thrown when business logic constraint is violated.
 * HTTP 409 Conflict.
 *
 * Use this for: duplicate entries, invalid state transitions, constraint violations, etc.
 */
class BusinessRuleViolationException extends BaseApiException
{
    protected int $statusCode = 409;

    public function __construct(string $message = 'Business rule violation', ?string $errorCode = null)
    {
        parent::__construct($message, 0, $errorCode);
    }
}
