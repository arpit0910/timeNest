<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * UserNotFoundException — thrown when user cannot be found during auth operations.
 * HTTP 401 Unauthorized.
 *
 * Message is intentionally generic to avoid leaking information.
 */
class UserNotFoundException extends BaseApiException
{
    protected int $statusCode = 401;
    protected bool $shouldLog = false;

    public function __construct(string $message = 'User not found')
    {
        parent::__construct($message);
    }
}
