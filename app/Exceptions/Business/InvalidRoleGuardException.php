<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * InvalidRoleGuardException — thrown when role's guard doesn't match expected guard.
 * HTTP 403 Forbidden.
 */
class InvalidRoleGuardException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Invalid role configuration')
    {
        parent::__construct($message);
    }
}
