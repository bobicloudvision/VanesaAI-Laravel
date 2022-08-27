<?php

namespace App\Console\Commands;

use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Robot\RobotTalk;
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

        while(true) {
            $findConversations = Conversation::get();
            foreach ($findConversations as $conversation) {

                $findMessage = ConversationMessage::where('conversation_id', $conversation->id)->orderBy('id', 'desc')->first();
                $findMessage->status = ConversationMessage::STATUS_SEEN;
                $findMessage->save();

                if ($findMessage->send_by == ConversationMessage::SEND_BY_USER) {

                    $talk = new RobotTalk();
                    $talk->setInput($findMessage->message);
                    $robotResponse = $talk->getResponse();

                    $newMessage = new ConversationMessage();
                    $newMessage->send_by = ConversationMessage::SEND_BY_ROBOT;
                    $newMessage->conversation_id = $conversation->id;
                    $newMessage->message = $robotResponse;
                    $newMessage->save();
                }

                /* if ($findMessage->send_by == ConversationMessage::SEND_BY_ROBOT) {

                     $newMessage = new ConversationMessage();
                     $newMessage->send_by = ConversationMessage::SEND_BY_ROBOT;
                     $newMessage->conversation_id = $conversation->id;
                     $newMessage->message = 'Защо млъкна?';
                     $newMessage->save();

                 }*/
            }

            sleep(60);
        }

        return 0;
    }
}
