<?php

namespace App\Http\Resources\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "sender_id" => $this->sender_id,
            "sender_name" => $this->notificationSender->name,
            "sender_thumbnail" => $this->notificationSender->profilePhotoPath,
            "subject" => $this->subject,
            "body" => $this->body,
            "is_read" => $this->is_read,
            "created_at" => Carbon::parse($this->created_at)->format('d F, Y'),
        ];
    }
}
