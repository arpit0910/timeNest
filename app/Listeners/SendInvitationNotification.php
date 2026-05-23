<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\InvitationCreated;
use App\Mail\InvitationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvitationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(InvitationCreated $event): void
    {
        Mail::to($event->invitation->email)
            ->send(new InvitationMail($event->invitation, $event->rawToken));
    }
}
