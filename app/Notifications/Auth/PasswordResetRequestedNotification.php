<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetRequestedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $plainToken,
        public readonly User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $expireMinutes = config('timenest.password_reset.expire', 60);
        $url = route('password.reset.web', [
            'token' => $this->plainToken,
            'email' => $this->user->email
        ]);

        return (new MailMessage)
            ->subject('Reset Your TimeNest Password')
            ->view('emails.auth.password-reset-request', [
                'user' => $this->user,
                'url' => $url,
                'expireMinutes' => $expireMinutes,
            ]);
    }
}
