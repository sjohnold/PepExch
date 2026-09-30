<?php

namespace App\Events;

use App\Http\Resources\ConversationManageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SellerConversationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public $message) {}

    public function broadcastOn()
    {
        // Make it a private channel for both users
        // return ['chat_' .  $this->message->conversation_id];
        return new PrivateChannel('chat.' . $this->message->conversation_id);
    }

    public function broadcastAs()
    {
        return 'conversation_sent'; // listen for this name in JS
    }

    public function broadcastWith()
    {
        return [
            'message' => ConversationManageResource::make($this->message),
        ];
    }
}
