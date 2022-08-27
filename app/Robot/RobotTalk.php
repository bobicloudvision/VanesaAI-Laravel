<?php
namespace App\Robot;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RobotTalk
{
    public $input = '';
    private $mainDir = '';
    private $pythonDir = '';

    public function __construct()
    {
        $this->mainDir = $this->getMainDir();
        $this->pythonDir = $this->getPythonDir();
    }

    public function setInput(string $text)
    {
        $this->input = $text;
    }

    public function getResponse()
    {

        $process = new Process([$this->pythonDir, $this->mainDir . '/python/dialog_nltk/chat-input.py', $this->input]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $robotResponse = $process->getOutput();

        return $this->parseResponse($robotResponse);
    }

    /**
     * @param $conversationId
     * @param $action
     * @return string
     * Example: {{RobotTalk::makeAction($conversation_id, 'emotional_status_explain')}}
     */
    public static function makeAction($conversationId = false, $action = '')
    {

        if ($action == 'emotional_status_up') {

        }

        return $action;
    }

    public static function noResponse($conversationId = false)
    {
        return "Мислих.. но не знам как да ти отговоря...";
    }

    private function parseResponse($text)
    {
        $data = [];
        $data['robot_name'] = 'Ванеса';
        $data['time_now'] = date("H:i:s");
        $data['date_now'] = date("Y-m-d");
        $data['conversation_id'] = 4;

        return Blade::render($text, $data);
    }

    private function getMainDir()
    {
        return dirname(dirname(__DIR__));
    }

    private function getPythonDir()
    {
        return '/Users/bobi/opt/anaconda3/bin/python';
    }
}
