<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Stevebauman\Location\Facades\Location;

class TwoFactorBruteForceWarningNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $locationString = 'Unknown Location';
    private string $browser = 'Unknown Browser';
    private string $os = 'Unknown OS';
    private string $device = 'desktop';

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly User $user,
        public readonly string $ipAddress,
        public readonly string $userAgent
    ) {
        if ($this->ipAddress && $this->ipAddress !== '127.0.0.1') {
            $pos = Location::get($this->ipAddress);
            if ($pos && $pos->cityName && $pos->countryName) {
                $this->locationString = "{$pos->cityName}, {$pos->countryName}";
            }
        }

        if ($this->userAgent) {
            $parser = new \WhichBrowser\Parser(['User-Agent' => $this->userAgent]);
            $this->browser  = $parser->browser->name ?? 'Unknown Browser';
            $this->os       = $parser->os->name ?? 'Unknown OS';
            $this->device   = $parser->device->type ?? 'desktop';
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Security Alert: Suspicious Login Attempts Detected')
            ->view('emails.auth.2fa-brute-force-warning', [
                'user'      => $this->user,
                'ipAddress' => $this->ipAddress,
                'location'  => $this->locationString,
                'browser'   => $this->browser,
                'os'        => $this->os,
                'device'    => ucfirst($this->device),
                'time'      => now()->format('F j, Y, g:i a T'),
            ]);
    }
}
