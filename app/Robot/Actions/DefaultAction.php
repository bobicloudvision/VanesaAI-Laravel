<?php

namespace App\Robot\Actions;

abstract class DefaultAction implements IAction
{

    public $conversationId;

    public function setConversationId($id)
    {
        $this->conversationId = $id;
    }

    public function make()
    {

    }
}
