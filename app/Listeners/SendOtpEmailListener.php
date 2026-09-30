<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\SendOTPMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOtpEmailListener implements ShouldQueue
{
    public function __construct() {}

    public function handle(UserRegistered $event)
    {
        Mail::to($event->user->email)->send(new SendOTPMail($event->user, $event->otp));
    }
}
