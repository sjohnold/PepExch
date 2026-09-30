<?php

namespace App\Http\Resources;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MessageManageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray(Request $request): array
    {
        $mediaPath = null;
        $getMedia = MessageRepository::query()->with('thumbnails')->find($this->id);

        foreach ($getMedia->thumbnails as $thumbnail) {
            if ($thumbnail && Storage::disk('public')->exists($thumbnail->src)) {
                $mediaPath = Storage::url($thumbnail->src);
            }
        }




        return [
            'id' => $this->id,
            'contact' => $this->contact,
            'conversation_id' => $this->conversation_id,
            'sender_id'=>$this->sender_id,
            'receiver_id' => $this->receiver_id,
            'product' => SellingPostForConversationResource::make($this->sellingPost),
            'is_read' => $this->is_read,
            'profile_img' => $this->myPhoto,
            'is_online' => $this->chatUser->is_online,
            'media' => $mediaPath,
            'offer' => $this->offer ? OfferResource::make($this->offer) : null,
            'created_at' => $this->created_at,

        ];
    }
}
