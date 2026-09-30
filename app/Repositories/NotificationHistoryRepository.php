<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\NotificationHistory;

class NotificationHistoryRepository extends Repository
{
    public static function model()
    {
        return NotificationHistory::class;    
    }
}