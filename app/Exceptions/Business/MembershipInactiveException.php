<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * MembershipInactiveException — thrown when membership is not active.
 * HTTP 403 Forbidden.
 *
 * Never leaks that membership exists — generic message for security.
 */
class MembershipInactiveException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Access denied')
    {
        parent::__construct($message);
    }
}
