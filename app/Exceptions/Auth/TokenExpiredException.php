<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * TokenExpiredException — thrown when a JWT has expired.
 * HTTP 401 Unauthorized.
 */
class TokenExpiredException extends BaseApiException
{
    protected int $statusCode = 401;
    protected bool $shouldLog = false;

    public function __construct(string $message = 'Token has expired')
    {
        parent::__construct($message);
    }
}
