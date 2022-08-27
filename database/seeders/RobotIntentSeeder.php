<?php

namespace Database\Seeders;

use App\Models\RobotIntent;
use App\Models\RobotIntentPattern;
use App\Models\RobotIntentResponse;
use Illuminate\Database\Seeder;

class RobotIntentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents('python/dialog_nltk/intents.json');
        $json = json_decode($json, true);
        foreach ($json['intents'] as $intent) {

            $findIntent = RobotIntent::where('tag', $intent['tag'])->first();
            if ($findIntent == null) {
                $findIntent = new RobotIntent();
            }
            $findIntent->tag = $intent['tag'];
            $findIntent->name = $intent['tag'];
            $findIntent->save();
;
            foreach ($intent['responses'] as $response) {

                $findResponse = RobotIntentResponse::where('value', $response)->first();
                if ($findResponse == null) {
                    $findResponse = new RobotIntentResponse();
                    $findResponse->robot_intent_id = $findIntent->id;
                }
                $findResponse->value = $response;
                $findResponse->save();
            }

            foreach ($intent['patterns'] as $pattern) {

                $findPattern = RobotIntentPattern::where('value', $pattern)->first();
                if ($findPattern == null) {
                    $findPattern = new RobotIntentPattern();
                    $findPattern->robot_intent_id = $findIntent->id;
                }
                $findPattern->value = $pattern;
                $findPattern->save();
            }

        }
    }
}
