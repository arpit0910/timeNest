<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * InvitationAlreadyAcceptedException — thrown when invitation has already been accepted.
 * HTTP 409 Conflict.
 */
class InvitationAlreadyAcceptedException extends BaseApiException
{
    protected int $statusCode = 409;

    public function __construct(string $message = 'Invitation has already been accepted')
    {
        parent::__construct($message);
    }
}
