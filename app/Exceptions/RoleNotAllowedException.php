<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Thrown when a role with an invalid guard is used in a context.
 * E.g., assigning a platform-guard role via corporation invitation API.
 * HTTP 422 Unprocessable Entity.
 */
class RoleNotAllowedException extends HttpException
{
    public function __construct(string $message = 'This role cannot be used in this context')
    {
        parent::__construct(422, $message);
    }
}
