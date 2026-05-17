<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * InvitationRevokedException — thrown when invitation has been revoked.
 * HTTP 409 Conflict.
 */
class InvitationRevokedException extends BaseApiException
{
    protected int $statusCode = 409;

    public function __construct(string $message = 'Invitation has been revoked')
    {
        parent::__construct($message);
    }
}
