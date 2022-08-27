<?php

namespace App\Filament\Pages;

use App\Models\Conversation;
use App\Models\ConversationMessage;
use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.chat';

    public $message = '';

    public function sendMessage(): void
    {

        $sessionId = request()->session()->getId();

        $findConversation = Conversation::where('session_id', $sessionId)->first();
        if ($findConversation == null) {
            $findConversation = new Conversation();
            $findConversation->session_id = $sessionId;
            $findConversation->save();
        }

        $message = new ConversationMessage();
        $message->conversation_id = $findConversation->id;
        $message->message = $this->message;
        $message->send_by = ConversationMessage::SEND_BY_USER;
        $message->save();

        $this->message = '';
    }
}
