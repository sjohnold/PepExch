<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Notification;

class NotificationRepository extends Repository
{
    public static function model()
    {
        return Notification::class;
    }
}
