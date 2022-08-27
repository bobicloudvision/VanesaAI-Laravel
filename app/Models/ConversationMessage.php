<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationMessage extends Model
{
    use HasFactory;

    const STATUS_SENT = 'SENT';
    const STATUS_RECEIVED = 'RECEIVED';
    const STATUS_SEEN = 'SEEN';
    const STATUS_WRITING = 'WRITING';

    const SEND_BY_USER = 'USER';
    const SEND_BY_ROBOT = 'ROBOT';

}
