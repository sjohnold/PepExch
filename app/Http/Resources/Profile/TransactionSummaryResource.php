<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\Wallet\WalletTransactionResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionSummaryResource extends JsonResource
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
            "transaction_name" => $this->boostPlan?->name ?? "Wallet Recharge",
            "identifier" => $this->identifier,
            "user_name" => $this->name,
            "user_email" => $this->email,
            "user_phone" => $this->contact,
            "payment_method" => $this->payment_method?->name,
            "sustain_days" => (int) $this->boostPlan?->sustain_days,
            "amount" => (double) $this->amount,
            "created_at" => Carbon::parse($this->created_at)->format('d F, Y'),
            "wallet" => WalletTransactionResource::make($this->walletTransaction),
        ];
    }
}
