<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your TimeNest Password Has Been Changed')
            ->view('emails.auth.password-changed', [
                'user' => $this->user,
                'changedAt' => now()->toDayDateTimeString(),
            ]);
    }
}
