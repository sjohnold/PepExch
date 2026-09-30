<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Message;
use App\Models\MessageThumbnail;

class MessageRepository extends Repository
{
    public static function model()
    {
        return Message::class;
    }


    public static function storeByRequest($request)
    {
        $senderId   = auth()->id();
        $receiverId = $request->receiver_id;

        // Get or create conversation
        $conversation = ConversationRepository::findBySenderAndReceiver($senderId, $receiverId);

        // First handle normal message
        $content = $request->message ?? $request->offer_message;

        // Create the message

        $message = self::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => auth()->id(),
            'selling_post_id' => $request->selling_post_id ?? null,
            'offer_id'        => $request->offer_id ?? null,
            'receiver_id'     => $receiverId,
            'contact'         => $content,
        ]);



        // Optional file
        if ($request->hasFile('chatFile')) {
            $media = MediaRepository::storeByRequest($request->file('chatFile'), 'chat');

            MessageThumbnail::create([
                'message_id' => $message->id,
                'media_id'   => $media->id,
            ]);
        }

        return $message;
    }

    



}
