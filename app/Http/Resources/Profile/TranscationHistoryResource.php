<?php

namespace App\Http\Resources\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranscationHistoryResource extends JsonResource
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
            "identifier" => $this->identifier,
            "user_name" => $this->name ?? $this->user?->name,
            "plan_name" => $this->boostPlan?->name ?? "Wallet Recharge",
            "sustain_days" => (int) $this->boostPlan?->sustain_days ?? 0,
            "amount" => (double) $this->amount,
            "created_at" => Carbon::parse($this->created_at)->format('d F, Y'),
            "status" => $this->status,
            "payment_method" => $this->payment_method?->name
        ];
    }
}
