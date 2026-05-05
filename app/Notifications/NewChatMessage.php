<?php

namespace App\Notifications;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewChatMessage extends Notification
{
    use Queueable;

    public function __construct(
        public Message $message,
        public Conversation $conversation,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $other = $this->conversation->otherParty($notifiable);

        return [
            'message_id' => $this->message->id,
            'conversation_id' => $this->conversation->id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender?->nom ?? 'Utilisateur',
            'preview' => $this->message->body
                ?? ($this->message->attachment_path ? '📷 Image' : ''),
            'from_name' => $other?->nom,
        ];
    }
}
