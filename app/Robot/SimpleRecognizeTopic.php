<?php

namespace App\Robot;

use App\Models\RobotIntent;
use App\Models\RobotIntentTopic;

class SimpleRecognizeTopic
{
    public $input = '';

    public function setInput(string $text)
    {
        $text = str_replace(',', '', $text);
        $text = str_replace('.', '', $text);
        $text = str_replace('!', '', $text);
        $text = str_replace('?', '', $text);
        $text = mb_strtolower($text);
        $text = trim($text);

        $this->input = $text;
    }

    public function getResponse()
    {
        $response = '';
        $textBlocks = $this->getTextBlocks();
        if (!empty($textBlocks)) {
            foreach ($textBlocks as $block) {
                $response .= $block['response'] . '<br />';
            }
        }

        return $response;
    }

    public function getTextBlocks()
    {
        $textBlocks = [];

        $input = $this->input;

        $getRobotIntentTopics = RobotIntentTopic::all();
        foreach ($getRobotIntentTopics as $getRobotIntentTopic) {
            $getRobotIntents = RobotIntent::where('robot_intent_topic_id', $getRobotIntentTopic->id)->get();
            if ($getRobotIntents->count() == 0) {
                continue;
            }
            foreach ($getRobotIntents as $intent) {
                foreach ($intent->patterns()->get() as $pattern) {
                    $value = $pattern->cleanedValue();
                    if (mb_strpos($input, $value) !== false) {
                        $input = str_replace($value, '', $input);
                        $randomResponse = [];
                        foreach ($intent->responses()->get() as $response) {
                            $randomResponse[] = $response->value;
                        }
                        shuffle($randomResponse);
                        $textBlocks[$intent->id] = [
                            'pattern' => $value,
                            'response' => $randomResponse[0],
                        ];
                    }
                }
            }
        }

        return $textBlocks;
    }

}
