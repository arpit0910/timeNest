<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * JwtContextMissingException — thrown when JWT context is missing/not resolved.
 * HTTP 401 Unauthorized.
 */
class JwtContextMissingException extends BaseApiException
{
    protected int $statusCode = 401;

    public function __construct(string $message = 'Unauthenticated')
    {
        parent::__construct($message);
    }
}
