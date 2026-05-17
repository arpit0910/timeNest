<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * EmailNotVerifiedException — thrown when login is attempted with an unverified email.
 * HTTP 403 Forbidden.
 */
class EmailNotVerifiedException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Email address must be verified')
    {
        parent::__construct($message);
    }
}
