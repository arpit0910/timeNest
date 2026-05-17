<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * FullAuthenticationRequiredException — thrown when endpoint requires full auth but only temp token provided.
 * HTTP 403 Forbidden.
 */
class FullAuthenticationRequiredException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Full authentication required')
    {
        parent::__construct($message);
    }
}
