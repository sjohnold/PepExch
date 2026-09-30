<?php

namespace App\Services\Notification;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotifyService
{
    private $firebaseMessaging;

    /**
     * Construct the NotificationServices object.
     *
     * Instantiates the Firebase Messaging Factory and provides the path to the
     * service account credentials.
     *
     * The credential path is supplied through FIREBASE_CREDENTIALS and must
     * point to a file outside the web root.
     */
    public function __construct()
    {
        $credentialPath = config('services.firebase.credentials');
        if (!is_string($credentialPath) || $credentialPath === '' || !is_readable($credentialPath)) {
            throw new \RuntimeException('Firebase credentials are not configured.');
        }

        $this->firebaseMessaging = (new Factory)
            ->withServiceAccount($credentialPath)
            ->createMessaging();
    }

    /**
     * Send a single notification.
     *
     * @param string $deviceToken device token from where notification will be sent.
     * @param string $title title of the notification.
     * @param string $message message of the notification.
     * @return void
     */
    public function send(string $deviceToken, string $subject, string $body): void
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::create($subject, $body));

        $this->firebaseMessaging->send($message->withChangedTarget('token', $deviceToken));
    }

    /**
     * Send multiple notifications.
     *
     * @param array $deviceTokens device tokens from where notifications will be sent.
     * @param string $title title of the notification.
     * @param string $message message of the notification.
     * @return void
     */
    public function sends(array $deviceTokens, string $subject, string $body): void
    {
        $data = [
            'title' => $subject,
            'body' => $body,
        ];

        $message = CloudMessage::new()
            ->withData($data)
            ->withNotification(Notification::create($subject, $body));

        $this->firebaseMessaging->sendMulticast($message, $deviceTokens);
    }
}
