<?php

namespace App\Listeners;

use App\Events\NotifyManagementEvent;
use App\Events\NotifyManagementMailEvent;
use App\Models\Notification;
use App\Models\NotificationHistory;
use App\Services\Notification\FirebaseNotifyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyManagementListener
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
    public function handle(NotifyManagementEvent $event): void
    {
        $receiverIds = (array) $event->receiverIds;

        if (!$receiverIds) {
            NotificationHistory::create([
                'receiver_id' => null,
                'sender_id'   => $event->senderId,
                'subject'     => $event->subject,
                'body'        => $event->body,
            ]);

            $this->firebaseNotificationFunctionality($event->subject, $event->body);

            // For Mail
            NotifyManagementMailEvent::dispatch(
                $event->receiverIds,
                $event->subject,
                $event->body
            );
        } else {
            foreach ($receiverIds as $receiverId) {
                NotificationHistory::create([
                    'receiver_id' => $receiverId,
                    'sender_id'   => $event->senderId,
                    'subject'     => $event->subject,
                    'body'        => $event->body,
                ]);

                $this->firebaseNotificationFunctionality($event->subject, $event->body);

                // For Mail
                NotifyManagementMailEvent::dispatch(
                    $receiverId,
                    $event->subject,
                    $event->body
                );
            }
        }
    }

    private function firebaseNotificationFunctionality($subject, $body)
    {
        $token = [
            "en1h0A5YT2aeU70DodOT9-:APA91bE1_EfBXHm1ca1JRlgsSyC7RI84rNOU8rdWGmMVPrP2AEzYsUDCMohwlKZdpbk4WJpBfRpJ9p0RhTsisXKSuZJoEJ57mppUeXtZZmpzV5VkBIB26C8"
        ];

        $firebaseService = new FirebaseNotifyService();
        $firebaseService->sends($token, $subject, $body);
    }
}
