<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RobotIntentTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'flow_json',
    ];

    public function slug()
    {
        return Str::slug($this->name,'_');
    }
}
