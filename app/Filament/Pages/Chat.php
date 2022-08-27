<?php

namespace App\Filament\Pages;

use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Robot\RobotTalk;
use Filament\Pages\Page;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.chat';

    public $message = '';
    public $conversationMessages = [];

    public function mount()
    {
        $this->updateConversationMessage();
    }

    public function updateConversationMessage()
    {
        $sessionId = request()->session()->getId();

        $findConversation = Conversation::where('session_id', $sessionId)->first();
        if ($findConversation != null) {
            $this->conversationMessages = ConversationMessage::where('conversation_id', $findConversation->id)->get();
        }
    }

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

        $talk = new RobotTalk();
        $talk->setInput($this->message);
        $robotResponse = $talk->getResponse();

        $message = new ConversationMessage();
        $message->conversation_id = $findConversation->id;
        $message->message = $robotResponse;
        $message->send_by = ConversationMessage::SEND_BY_ROBOT;
        $message->save();

        $this->message = '';
        $this->updateConversationMessage();
        $this->dispatchBrowserEvent('messageSent');

    }

}
