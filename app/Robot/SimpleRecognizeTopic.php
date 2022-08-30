<?php

namespace App\Robot;

use App\Models\RobotIntent;
use App\Models\RobotIntentTopic;

class SimpleRecognizeTopic
{
    public $input = '';

    public function setInput(string $text)
    {
        $this->input = $text;
    }

    public function getResponse()
    {
        $getRobotIntentTopics = RobotIntentTopic::all();
        foreach ($getRobotIntentTopics as $getRobotIntentTopic) {
            $getRobotIntents = RobotIntent::where('robot_intent_topic_id', $getRobotIntentTopic->id)->get();
            if ($getRobotIntents->count() == 0) {
                continue;
            }
            foreach ($getRobotIntents as $intent) {
                foreach ($intent->patterns()->get() as $pattern) {

                    $valueMatched = false;
                    $value = $pattern->cleanedValue();

                    if ($value == $this->input) {
                        $valueMatched = true;
                    }
                    if (!$valueMatched) {
                        continue;
                    }

                    $randomResponse = [];
                    foreach ($intent->responses()->get() as $response) {
                        $randomResponse[] = $response->value;
                    }
                    shuffle($randomResponse);
                    return $randomResponse[0];
                }
            }
        }

        dump($this->input);

        return $this->input;
    }
}
