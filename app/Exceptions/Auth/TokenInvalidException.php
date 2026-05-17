<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * TokenInvalidException — thrown when a JWT is malformed or invalid.
 * HTTP 401 Unauthorized.
 */
class TokenInvalidException extends BaseApiException
{
    protected int $statusCode = 401;
    protected bool $shouldLog = false;

    public function __construct(string $message = 'Token is invalid')
    {
        parent::__construct($message);
    }
}
