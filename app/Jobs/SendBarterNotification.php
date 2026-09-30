<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBarterNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected string $title;
    protected string $message;
    protected array $channels;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $title, string $message, array $channels = ['email', 'viber', 'whatsapp'])
    {
        $this->user = $user;
        $this->title = $title;
        $this->message = $message;
        $this->channels = $channels;
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $notificationService): void
    {
        $notificationService->send($this->user, $this->title, $this->message, $this->channels);
    }
}
