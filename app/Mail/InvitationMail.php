<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Invitation\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $acceptUrl;

    public function __construct(
        public readonly Invitation $invitation,
        public readonly string $rawToken
    ) {
        $frontendUrl = config('app.frontend_url') ?: config('app.url');
        $this->acceptUrl = rtrim($frontendUrl, '/') . '/invitations/accept?token=' . $rawToken;
    }

    public function envelope(): Envelope
    {
        $corpName = $this->invitation->corporation->legal_name;
        return new Envelope(
            subject: "Invitation to join {$corpName} on TimeNest",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
        );
    }
}
