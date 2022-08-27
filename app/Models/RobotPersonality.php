<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotPersonality extends Model
{
    use HasFactory;

    public $table = 'robot_personality';

    public $fillable = [
        'personality_key',
        'personality_value'
    ];

}
