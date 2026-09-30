<?php

namespace App\Http\Resources\SellerInfo;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerReviewResource extends JsonResource
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
            "rating" => (float) $this->rating,
            "comment" => $this->comment,
            "reviewer_id" => $this->reviewer_id,
            "reviewer_name" => $this->reviewer->name,
            "reviewer_thumbnail" => $this->reviewer->profilePhotoPath,
            "created_at" => Carbon::parse($this->created_at)->format('d, F, Y'),
        ];
    }
}
