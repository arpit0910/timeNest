<?php

declare(strict_types=1);

namespace App\Mail\Auth;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * VerifyEmailMail — the email verification mailable.
 *
 * Renders the enterprise-branded verification email with a CTA button
 * linking to the frontend verification page.
 *
 * Follows the same Envelope + Content pattern as InvitationMail.
 */
class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $verificationUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify your timeNest account',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.verify-email',
        );
    }
}
