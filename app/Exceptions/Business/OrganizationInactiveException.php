<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * OrganizationInactiveException — thrown when operation on inactive organization is attempted.
 * HTTP 403 Forbidden.
 *
 * Never leaks that organization exists — generic message for security.
 */
class OrganizationInactiveException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Access denied')
    {
        parent::__construct($message);
    }
}
