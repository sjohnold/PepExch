<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class NotificationService
{
    /**
     * Send notification to user based on their matrix settings.
     */
    public function send(User $user, string $title, string $message, array $channels = ['email']): void
    {
        $matrix = $user->notif_matrix ?? ['email' => true];

        foreach ($channels as $channel) {
            if (!isset($matrix[$channel]) || !$matrix[$channel]) {
                continue;
            }

            switch ($channel) {
                case 'email':
                    $this->sendEmail($user, $title, $message);
                    break;
                case 'viber':
                    $this->sendWithRateLimit($user, 'viber', $message);
                    break;
                case 'whatsapp':
                    $this->sendWithRateLimit($user, 'whatsapp', $message);
                    break;
            }
        }
    }

    protected function sendWithRateLimit(User $user, string $channel, string $message): void
    {
        $key = "notification:{$channel}:{$user->id}";
        $maxAttempts = 3;
        $decaySeconds = 3600; // 1 hour

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            Log::warning("Rate limit exceeded for {$channel} notification to user {$user->id}");
            return;
        }

        if ($channel === 'viber') {
            $this->sendViber($user, $message);
        } else {
            $this->sendWhatsApp($user, $message);
        }

        RateLimiter::hit($key, $decaySeconds);
    }

    protected function sendEmail(User $user, string $title, string $message): void
    {
        // Placeholder for Mail::send or Notification::send
        Log::info("Email sent to {$user->email}: [{$title}] {$message}");
    }

    protected function sendViber(User $user, string $message): void
    {
        // Viber API integration logic
        Log::info("Viber message sent to {$user->contact_number}: {$message}");
    }

    protected function sendWhatsApp(User $user, string $message): void
    {
        // WhatsApp API (e.g. Twilio) integration logic
        Log::info("WhatsApp message sent to {$user->contact_number}: {$message}");
    }
}
