<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChatUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $myId = Auth::id();
        $senderId = $this->sender_id;
        $choseCorrectUser = $myId == $senderId ? $this->receiver : $this->sender;


        $lastActive = Carbon::parse($choseCorrectUser->last_active)->diffForHumans();
        $lastMessage = Carbon::parse($choseCorrectUser->lastMessage?->created_at)->diffForHumans();

        return [
            'id' => (int) $this->id,
            'receiver_id' => $choseCorrectUser->id,
            'name' => $choseCorrectUser->name,
            'profile_photo' => $choseCorrectUser->profilePhotoPath,
            'last_active' => $lastActive,
            'last_message_time' => $lastMessage,
            'last_message' => $choseCorrectUser->lastMessage?->contact,
            'is_online' => (bool) $choseCorrectUser->is_online,
            'is_read' => (bool) $choseCorrectUser->lastMessage?->is_read,
        ];
    }
}
