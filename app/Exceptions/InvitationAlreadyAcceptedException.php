<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Thrown when attempting to accept an already-accepted invitation.
 * HTTP 409 Conflict.
 */
class InvitationAlreadyAcceptedException extends HttpException
{
    public function __construct(string $message = 'This invitation has already been accepted')
    {
        parent::__construct(409, $message);
    }
}
