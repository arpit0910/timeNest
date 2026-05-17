<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Business\InvitationRevokedException as BusinessInvitationRevokedException;

/**
 * Legacy alias for backwards compatibility.
 * Use App\Exceptions\Business\InvitationRevokedException instead.
 *
 * @deprecated Use App\Exceptions\Business\InvitationRevokedException
 */
class InvitationRevokedException extends BusinessInvitationRevokedException
{
    public function __construct(string $message = 'This invitation has been revoked')
    {
        parent::__construct($message);
    }
}
