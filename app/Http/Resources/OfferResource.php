<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'selling_post_id' => $this->selling_post_id,
            'sender_items' => is_string($this->sender_items) ? json_decode($this->sender_items) : $this->sender_items,
            'receiver_items' => is_string($this->receiver_items) ? json_decode($this->receiver_items) : $this->receiver_items,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
