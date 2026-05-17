<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Business\InvitationAlreadyAcceptedException as BusinessInvitationAlreadyAcceptedException;

/**
 * Legacy alias for backwards compatibility.
 * Use App\Exceptions\Business\InvitationAlreadyAcceptedException instead.
 *
 * @deprecated Use App\Exceptions\Business\InvitationAlreadyAcceptedException
 */
class InvitationAlreadyAcceptedException extends BusinessInvitationAlreadyAcceptedException
{
    public function __construct(string $message = 'This invitation has already been accepted')
    {
        parent::__construct($message);
    }
}
