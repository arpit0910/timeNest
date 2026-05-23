<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Invitation\Invitation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Invitation $invitation,
        public readonly string $rawToken
    ) {}
}
