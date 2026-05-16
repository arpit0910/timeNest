<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Thrown when an invitation has been revoked by an admin.
 * HTTP 410 Gone.
 */
class InvitationRevokedException extends HttpException
{
    public function __construct(string $message = 'This invitation has been revoked')
    {
        parent::__construct(410, $message);
    }
}
