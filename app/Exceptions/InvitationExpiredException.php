<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Thrown when an invitation token has expired.
 * HTTP 410 Gone.
 */
class InvitationExpiredException extends HttpException
{
    public function __construct(string $message = 'This invitation has expired')
    {
        parent::__construct(410, $message);
    }
}
