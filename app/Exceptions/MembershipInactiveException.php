<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Thrown when a user's corporation membership is not in an active state.
 * HTTP 403 Forbidden.
 */
class MembershipInactiveException extends HttpException
{
    public function __construct(string $message = 'Corporation membership is not active')
    {
        parent::__construct(403, $message);
    }
}
