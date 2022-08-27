<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonality extends Model
{
    use HasFactory;

    public $fillable = [
        'personality_key',
        'personality_value',
        'user_id'
    ];

}
