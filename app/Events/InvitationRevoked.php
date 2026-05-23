<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Invitation\Invitation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationRevoked
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Invitation $invitation
    ) {}
}
