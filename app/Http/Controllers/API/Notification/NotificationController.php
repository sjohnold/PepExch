<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Profile\NotificationResource;
use App\Repositories\NotificationHistoryRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Notification')]
class NotificationController extends Controller
{
     /**
     * Get All Notifacations
     *
     */
    #[BodyParameter('items_per_page', required: true, type: 'integer', example: 10)]
    #[BodyParameter('page_number', required: true, type: 'integer', example: 1)]

    public function getAllNotifications(Request $request)
    {
        $perPage = $request->input('items_per_page', 10);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;

        $query = NotificationHistoryRepository::query()
            ->with(['notificationReceiver', 'notificationSender', 'notifyProfilePic'])
            ->where('receiver_id', auth()->id());

        $totalCount =  $query->count();
        $notifications = $query->skip($skip)->take($perPage)->get();
        $perPageCount = $notifications->count();

        $unreadCount = NotificationHistoryRepository::query()
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        $data = [
            "total_count" => $totalCount,
            "per_page_Count" => $perPageCount,
            "total_unread_notifications" => $unreadCount,
            "notifications" => NotificationResource::collection($notifications),
        ];

        return $this->json("Notificationa Fetch Successfull", $data, 200);
    }




    /**
     * Unread Notifacations Count
     *
     */
    public function notificationsCount()
    {
        $unreadCount = NotificationHistoryRepository::query()
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return $this->json("Notification Unread Count Fetched Successfully", ["unread_count" => $unreadCount], 200);
    }




    /**
     * Read Single Notifacations
     *
     */
    public function notificationRead($id)
    {
        $notification = NotificationHistoryRepository::query()->find($id);
        if (!$notification) {
            return $this->json("Notification not found", [], 404);
        }
        $notification->is_read = true;
        $notification->save();
        return $this->json("Notification read Successfully", [], 200);
    }




    /**
     * Read All Notifacations
     *
     */
    public function notificationReadAll()
    {
        $id = auth()->id();
        $notification = NotificationHistoryRepository::query()->where('receiver_id', $id)->where('is_read', false)->update(['is_read' => true]);
        return $this->json("Notification read-all fetch Successfully", [], 200);
    }
}
