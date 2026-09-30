<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Conversation;

class ConversationRepository extends Repository
{
    public static function model()
    {
        return Conversation::class;
    }
     /**
     * Find existing conversation between sender & receiver
     */
    public static function findBySenderAndReceiver(int $senderId, int $receiverId)
    {
        $conversation = self::query()
            ->where(function ($q) use ($senderId, $receiverId) {
                $q->where('sender_id', $senderId)
                    ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($q) use ($senderId, $receiverId) {
                $q->where('sender_id', $receiverId)
                    ->where('receiver_id', $senderId);
            })
        ->first();

        if (!$conversation) {
            $conversation = self::create([
                'sender_id'   => $senderId,
                'receiver_id' => $receiverId,
            ]);
        }

        return $conversation;
    }

}
