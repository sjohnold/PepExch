<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $resetLink;
    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }
    public function build()
    {
        return $this->subject('Reset Your Password')
            ->view('auth.reset_password')
            ->with(['resetLink' => $this->resetLink]);
    }
}
