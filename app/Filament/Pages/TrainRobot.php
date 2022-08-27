<?php

namespace App\Filament\Pages;

use App\Models\RobotIntent;
use Filament\Pages\Page;
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

        $saveIntents = [];

        $getRobotIntents = RobotIntent::get();
        foreach ($getRobotIntents as $intent) {
            $saveIntents[] = [
                'tag'=>$intent->tag,
                'patterns'=>$intent->patterns()->get()->pluck('value')->toArray(),
                'responses'=>$intent->responses()->get()->pluck('value')->toArray()
            ];
        }
        $saveIntents = json_encode(['intents'=>$saveIntents], JSON_PRETTY_PRINT);

        file_get_contents($mainDir . '/python/dialog_nltk/intents.json', $saveIntents);

        // which python
        $getPythonPath = '/Users/bobi/opt/anaconda3/bin/python';

        $process = new Process([$getPythonPath, $mainDir . '/python/dialog_nltk/train.py']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->log = $process->getOutput();
        $this->log = str_replace(PHP_EOL, '<br />', $this->log);

    }
}
