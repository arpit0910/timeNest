<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * InvitationExpiredException — thrown when invitation has expired.
 * HTTP 409 Conflict.
 */
class InvitationExpiredException extends BaseApiException
{
    protected int $statusCode = 409;

    public function __construct(string $message = 'Invitation has expired')
    {
        parent::__construct($message);
    }
}
