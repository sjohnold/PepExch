<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellingPostForConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'thumbnail' => $this->profilePath,
            'conditions' => $this->conditions,
            'asking_price' => $this->asking_price,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => getLocationName($this->latitude, $this->longitude),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
