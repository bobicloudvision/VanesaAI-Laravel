<?php

namespace App\Filament\Pages;

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

        $process = new Process(['python', $mainDir . '/python/dialog_nltk/train.py']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->log = $process->getOutput();

       // $this->log = 'Done!';

    }
}
