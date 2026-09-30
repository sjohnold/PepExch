<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnnouncementMail;
use App\Repositories\UserRepository;

class SendAnnouncementMail implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(AnnouncementCreated $event): void
    {
        $users = UserRepository::query()
            ->whereIn('id', $event->userIds)
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->queue(new AnnouncementMail($event->announcement));
        }
    }
}
