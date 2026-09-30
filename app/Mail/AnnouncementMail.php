<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnnouncementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $announcement; // Announcement object

    /**
     * Create a new message instance.
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $messageData = json_decode($this->announcement->message, true);

        return new Envelope(
            subject: 'New Announcement: ' . ($messageData['title'] ?? 'Announcement'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $messageData = json_decode($this->announcement->message, true);

        return new Content(
            view: 'email.announcement', // Blade template
            with: [
                'title' => $messageData['title'] ?? '',
                'body'  => $messageData['body'] ?? '',
                'type'  => $messageData['type'] ?? '',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
