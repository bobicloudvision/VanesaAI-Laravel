<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotIntent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tag',
        'robot_intent_topic_id',
    ];


    public function topic()
    {
        return $this->belongsTo(RobotIntentTopic::class, 'robot_intent_topic_id');
    }

    public function patterns()
    {
        return $this->hasMany(RobotIntentPattern::class, 'robot_intent_id');
    }

    public function responses()
    {
        return $this->hasMany(RobotIntentResponse::class, 'robot_intent_id');
    }

}
