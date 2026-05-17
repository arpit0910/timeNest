<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * InvalidCredentialsException — thrown when login credentials are invalid.
 * HTTP 401 Unauthorized.
 *
 * Message is intentionally generic to avoid leaking information about whether
 * the email exists in the system.
 */
class InvalidCredentialsException extends BaseApiException
{
    protected int $statusCode = 401;
    protected bool $shouldLog = false; // Validation noise, don't log

    public function __construct(string $message = 'Invalid credentials')
    {
        parent::__construct($message);
    }
}
