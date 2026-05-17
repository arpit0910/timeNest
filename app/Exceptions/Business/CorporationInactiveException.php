<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * CorporationInactiveException — thrown when operation on inactive corporation is attempted.
 * HTTP 403 Forbidden.
 *
 * Never leaks that corporation exists — generic message for security.
 */
class CorporationInactiveException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Access denied')
    {
        parent::__construct($message);
    }
}
