<?php

namespace App\Http\Resources\SellerInfo;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'address' => $this->address,
            'profile_photo' => $this->profilePhotoPath,
            'member_since' => Carbon::parse($this->created_at)->format('d F, Y'),
        ];
    }
}
