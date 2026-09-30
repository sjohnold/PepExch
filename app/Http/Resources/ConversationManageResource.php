<?php

namespace App\Http\Resources;

use App\Models\Message;
use App\Repositories\MessageRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ConversationManageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $mediaPath = null;

        if ($this->relationLoaded('thumbnails')) {
            foreach ($this->thumbnails as $thumbnail) {
                if ($thumbnail && Storage::disk('public')->exists($thumbnail->src)) {
                    $mediaPath = Storage::url($thumbnail->src);
                    break;
                }
            }
        }

         $profileImg = $this->sender_id == auth()->id()
        ? auth()->user()->profilePhotoPath
        : $this->chatUser?->profilePhotoPath ?? asset('assets/img/massage/author-05.png');

        return [
            'id'              => (int) $this->id,
            'contact'         => $this->contact,
            'sender_id'       => (int) $this->sender_id,
            'receiver_id'     => (int) $this->receiver_id,
            'conversation_id' => (int) $this->conversation_id,
            'product'         => SellingPostForConversationResource::make($this->sellingPost),
            'is_read'         => (bool) $this->is_read,
            'profile_img' => $profileImg,
            'is_online'       => (bool) $this->chatUser?->is_online,
            'media'           => $mediaPath,
            'created_at'      => $this->created_at->toDateTimeString(),
        ];
    }
}

