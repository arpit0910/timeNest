<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Business\InvitationExpiredException as BusinessInvitationExpiredException;

/**
 * Legacy alias for backwards compatibility.
 * Use App\Exceptions\Business\InvitationExpiredException instead.
 *
 * @deprecated Use App\Exceptions\Business\InvitationExpiredException
 */
class InvitationExpiredException extends BusinessInvitationExpiredException
{
    public function __construct(string $message = 'This invitation has expired')
    {
        parent::__construct($message);
    }
}
