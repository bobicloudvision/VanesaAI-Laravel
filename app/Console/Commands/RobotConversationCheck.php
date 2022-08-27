<?php

namespace App\Console\Commands;

use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Console\Command;

class RobotConversationCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:conversations-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $findConversations = Conversation::get();
        foreach ($findConversations as $conversation) {
            $findMessage = ConversationMessage::where('conversation_id', $conversation->id)->orderBy('id','desc')->first();
            if ($findMessage->send_by == ConversationMessage::SEND_BY_ROBOT) {

            }
        }

        return 0;
    }
}
