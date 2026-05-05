<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::find($conversationId);

    return $conversation && $conversation->involvesUser($user->id);
});

Broadcast::channel('online', function ($user) {
    if (! in_array($user->type_compte, ['client', 'vendeur'], true)) {
        return false;
    }

    return ['id' => $user->id, 'name' => $user->nom];
});
