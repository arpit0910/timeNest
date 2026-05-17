<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Business\MembershipInactiveException as BusinessMembershipInactiveException;

/**
 * Legacy alias for backwards compatibility.
 * Use App\Exceptions\Business\MembershipInactiveException instead.
 *
 * @deprecated Use App\Exceptions\Business\MembershipInactiveException
 */
class MembershipInactiveException extends BusinessMembershipInactiveException
{
    public function __construct(string $message = 'Corporation membership is not active')
    {
        parent::__construct($message);
    }
}
