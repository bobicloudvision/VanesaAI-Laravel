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

        $textBlocks = $this->getTextBlocks();
        if (empty($textBlocks)) {
            return '__robot_action_no_response__';
        }

        $response = '';
        foreach ($textBlocks as $block) {
            $response .= $block['response'] . PHP_EOL;
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
                    $recognized = false;
                    $expWordsOfPattern = explode(' ', $value);
                    $expWordsOfInput = explode(' ', $input);

                    if (count($expWordsOfPattern) > 1) {
                        if (mb_strpos($input, $value) !== false) {
                            $recognized = true;
                        }
                    } else {
                        if (in_array($value, $expWordsOfInput)) {
                            $recognized = true;
                        }
                    }

                    if ($recognized) {
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

        $inputSeperated = $this->input;
        foreach ($textBlocks as $block) {
            $inputSeperated = str_replace( $block['pattern'],'{'.$block['pattern'] .'}', $inputSeperated);
        }
        $inputSeperatedMatches = [];
        preg_match_all('/{(.*?)}/', $inputSeperated, $inputSeperatedMatches);

        $reorderedTextBlocks = [];
        foreach ($textBlocks as $block) {
            foreach ($inputSeperatedMatches[1] as $i=>$seperatedMatch) {
                if ($block['pattern'] == $seperatedMatch) {
                    $block['order'] = $i;
                    $reorderedTextBlocks[md5($block['pattern'])] = $block;
                }
            }
        }

        $block = array_column($reorderedTextBlocks, 'order');
        array_multisort($block, SORT_ASC, $reorderedTextBlocks);

        return $reorderedTextBlocks;
    }

    public function findWordPosition($string, $word) {

    }

}
