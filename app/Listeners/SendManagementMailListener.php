<?php

namespace App\Listeners;

use App\Events\NotifyManagementMailEvent;
use App\Events\UserRegistered;
use App\Mail\ManagementNotificationMail;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendManagementMailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(NotifyManagementMailEvent $event)
    {
        if ($event->receiverId === null) {
            $user = User::role('admin')->first();
        } else {
            $user = UserRepository::find($event->receiverId);
        }
        $email = $user->email;
        Mail::to($email)->send(
            new ManagementNotificationMail(
                $event->subject,
                $event->body
            )
        );
    }
}
