<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * TokenNotProvidedException — thrown when no JWT is present in the request.
 * HTTP 401 Unauthorized.
 */
class TokenNotProvidedException extends BaseApiException
{
    protected int $statusCode = 401;
    protected bool $shouldLog = false;

    public function __construct(string $message = 'Token not provided')
    {
        parent::__construct($message);
    }
}
