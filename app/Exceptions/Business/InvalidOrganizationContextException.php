<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * InvalidOrganizationContextException — thrown when organization context is invalid/missing.
 * HTTP 403 Forbidden.
 */
class InvalidOrganizationContextException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Invalid organization context')
    {
        parent::__construct($message);
    }
}
