<?php

namespace App\Services;

use App\Models\Offer;
use App\Jobs\SendBarterNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class EscrowService
{
    /**
     * Create a new exchange offer.
     */
    public function createOffer(array $data): Offer
    {
        $offer = Offer::create([
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'selling_post_id' => $data['selling_post_id'],
            'sender_items' => $data['sender_items'],
            'receiver_items' => $data['receiver_items'] ?? null,
            'status' => 'pending',
        ]);

        $offer->load('receiver', 'sellingPost');
        SendBarterNotification::dispatch($offer->receiver, "Novo ponuda za zamenu!", "Imate novu ponudu za vaš oglas: " . $offer->sellingPost->name);

        return $offer;
    }

    /**
     * Change offer status (accept, reject, withdraw).
     */
    public function changeStatus(Offer $offer, string $status, int $userId): bool
    {
        return DB::transaction(function () use ($offer, $status, $userId) {
            $offer = Offer::where('id', $offer->id)->lockForUpdate()->first();

            if (!$offer) {
                return false;
            }

            // Validation logic
            if ($status === 'accepted') {
                // Only receiver can accept
                if ($offer->receiver_id !== $userId) {
                    throw new Exception("Only the receiver can accept the offer.");
                }
                if ($offer->status !== 'pending') {
                    throw new Exception("Only pending offers can be accepted.");
                }
            }

            if ($status === 'rejected') {
                // Only receiver can reject
                if ($offer->receiver_id !== $userId) {
                    throw new Exception("Only the receiver can reject the offer.");
                }
                if ($offer->status !== 'pending') {
                    throw new Exception("Only pending offers can be rejected.");
                }
            }

            if ($status === 'withdrawn') {
                // Only sender can withdraw
                if ($offer->sender_id !== $userId) {
                    throw new Exception("Only the sender can withdraw the offer.");
                }
                if ($offer->status !== 'pending') {
                    throw new Exception("Only pending offers can be withdrawn.");
                }
            }

            $offer->status = $status;
            $offer->save();

            $targetUser = $status === 'withdrawn' ? $offer->receiver : $offer->sender;
            $title = "Status ponude je promenjen";
            $message = "Vaša ponuda za oglas " . $offer->sellingPost->name . " je sada: " . $status;
            
            SendBarterNotification::dispatch($targetUser, $title, $message);

            return true;
        });
    }

    /**
     * Confirm exchange from one side.
     */
    public function confirmExchange(Offer $offer, int $userId): bool
    {
        return DB::transaction(function () use ($offer, $userId) {
            $offer = Offer::where('id', $offer->id)->lockForUpdate()->first();

            if (!$offer || $offer->status !== 'accepted') {
                throw new Exception("Offer is not in accepted state or not found.");
            }

            if ($offer->sender_id === $userId) {
                $offer->sender_confirmed = true;
            } elseif ($offer->receiver_id === $userId) {
                $offer->receiver_confirmed = true;
            } else {
                throw new Exception("User is not a party in this offer.");
            }

            // Auto-complete if both confirmed
            if ($offer->sender_confirmed && $offer->receiver_confirmed) {
                $offer->status = 'completed';
                
                SendBarterNotification::dispatch($offer->sender, "Razmena završena!", "Čestitamo! Razmena za oglas " . $offer->sellingPost->name . " je uspešno završena.");
                SendBarterNotification::dispatch($offer->receiver, "Razmena završena!", "Čestitamo! Razmena za oglas " . $offer->sellingPost->name . " je uspešno završena.");
            }

            return $offer->save();
        });
    }
}
