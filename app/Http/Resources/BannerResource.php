<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title" => $this->title,
            "sub_title" => $this->sub_title,
            "description" => $this->description,
            "thumbnails" => $this->thumbnailPaths,
            "status" => (bool) $this->status,
        ];
    }
}
