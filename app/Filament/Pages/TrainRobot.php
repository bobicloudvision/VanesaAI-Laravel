<?php

namespace App\Filament\Pages;

use App\Models\RobotIntent;
use App\Models\RobotIntentTopic;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TrainRobot extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.train-robot';

    public $log = '';

    public function startTrainingAction(): void
    {
        $this->log = 'Start training...';

        $mainDir = dirname(dirname(dirname(__DIR__)));

        $getRobotIntentTopics = RobotIntentTopic::all();
        foreach ($getRobotIntentTopics as $getRobotIntentTopic) {

            $corpusFile = $mainDir . '/python/chatterbot/corpus/data/bulgarian/' . $getRobotIntentTopic->slug() . '.yml';
            if (!is_dir(dirname($corpusFile))) {
                mkdir(dirname($corpusFile));
            }

            $getRobotIntents = RobotIntent::where('robot_intent_topic_id', $getRobotIntentTopic->id)->get();
            if ($getRobotIntents->count() == 0) {
                continue;
            }

            $saveYml = '
categories:
  - ' . $getRobotIntentTopic->slug() . '
conversations:';

            foreach ($getRobotIntents as $intent) {
                foreach ($intent->patterns()->get() as $pattern) {
                    foreach ($intent->responses()->get() as $response) {
                        $saveYml .= "
  - - '$pattern->value'
    - '$response->value'";
                    }
                }
            }

            $saveYml = trim($saveYml);
            file_put_contents($corpusFile, $saveYml);

        }

        // which python
        $getPythonPath = '/Users/bobi/opt/anaconda3/bin/python';

        $process = new Process([$getPythonPath, $mainDir . '/python/chatterbot/train.py']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->log = $process->getOutput();
        $this->log = str_replace(PHP_EOL, '<br />', $this->log);

    }

   /* public function _______startTrainingAction(): void
    {
        $this->log = 'Start training...';

        $mainDir = dirname(dirname(dirname(__DIR__)));

        $getRobotIntentTopics = RobotIntentTopic::all();
        foreach ($getRobotIntentTopics as $getRobotIntentTopic) {

            $intentsJsonFile = $mainDir . '/python/dialog_nltk/topics/'.$getRobotIntentTopic->slug().'/intents.json';
            if (!is_dir(dirname($intentsJsonFile))) {
                mkdir(dirname($intentsJsonFile));
            }

            $saveIntents = [];
            $getRobotIntents = RobotIntent::where('robot_intent_topic_id', $getRobotIntentTopic->id)->get();
            if ($getRobotIntents->count() == 0) {
                continue;
            }

            foreach ($getRobotIntents as $intent) {
                $saveIntents[] = [
                    'tag' => $intent->tag,
                    'patterns' => $intent->patterns()->get()->pluck('value')->toArray(),
                    'responses' => $intent->responses()->get()->pluck('value')->toArray()
                ];
            }

            $saveIntents = json_encode(['intents' => $saveIntents], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents($intentsJsonFile, $saveIntents);

            // which python
            $getPythonPath = '/Users/bobi/opt/anaconda3/bin/python';

            $process = new Process([$getPythonPath, $mainDir . '/python/dialog_nltk/train.py', dirname($intentsJsonFile)]);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $this->log = $process->getOutput();
            $this->log = str_replace(PHP_EOL, '<br />', $this->log);

        }
    }*/
}
