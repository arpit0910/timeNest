<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Business\InvalidRoleGuardException;

/**
 * Legacy alias for backwards compatibility.
 * Use App\Exceptions\Business\InvalidRoleGuardException instead.
 *
 * @deprecated Use App\Exceptions\Business\InvalidRoleGuardException
 */
class RoleNotAllowedException extends InvalidRoleGuardException
{
    public function __construct(string $message = 'This role cannot be used in this context')
    {
        parent::__construct($message);
    }
}
