<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * AccountInactiveException — thrown when a user's account is deactivated.
 * HTTP 403 Forbidden.
 */
class AccountInactiveException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Account has been deactivated')
    {
        parent::__construct($message);
    }
}
