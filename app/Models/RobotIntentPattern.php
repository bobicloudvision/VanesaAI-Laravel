<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotIntentPattern extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
    ];

    public function cleanedValue()
    {
        $patternValue = str_replace(',','', $this->value);
        $patternValue = str_replace('.','', $patternValue);
        $patternValue = str_replace('!','', $patternValue);
        $patternValue = str_replace('?','', $patternValue);
        $patternValue = mb_strtolower($patternValue);
        $patternValue = trim($patternValue);

        return $patternValue;
    }
}
