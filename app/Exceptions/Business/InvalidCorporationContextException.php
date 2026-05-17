<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * InvalidCorporationContextException — thrown when corporation context is invalid/missing.
 * HTTP 403 Forbidden.
 */
class InvalidCorporationContextException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Invalid corporation context')
    {
        parent::__construct($message);
    }
}
