<?php

use App\Repositories\ConversationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = ConversationRepository::find($conversationId);

    if (! $conversation) {
        return false;
    }

    return $user->id == $conversation->sender_id || $user->id == $conversation->receiver_id;
}, ['guards' => ['web', 'admin']]);

Broadcast::channel('user-status', function ($user) {
    return Auth::check(); // Only logged in users can listen
});

