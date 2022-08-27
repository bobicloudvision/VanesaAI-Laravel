<?php

namespace App\Robot\Actions;

interface IAction
{
    public function setConversationId($id);
    public function make();
}
