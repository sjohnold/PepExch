<?php

namespace App\Http\Resources\SellerInfo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'asking_price'   => $this->asking_price,
            'sold_price'     => $this->sold_price,
            'description'    => $this->description,
            'model'          => $this->model,
            'number_of_view' => $this->number_of_view,
            'status'         => $this->status,
            'is_sold'        => $this->is_sold,
            'is_negotiable'  => $this->is_negotiable,
            'user_id'        => $this->user_id,
            'brand_id'       => $this->brand_id,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'thumbnail'      => $this->profilePath,
        ];
    }
}
