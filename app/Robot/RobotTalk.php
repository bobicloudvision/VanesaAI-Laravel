<?php
namespace App\Robot;

use App\Models\RobotIntentTopic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $text = trim($text);

        $this->input = $text;
    }

    public function getResponse()
    {

        $simpleRecognize = new SimpleRecognizeTopic();
        $simpleRecognize->setInput($this->input);
        $robotResponse = $simpleRecognize->getResponse();
        if ($robotResponse !== '__robot_action_no_response__') {
            return $this->parseResponse($robotResponse);
        }

        return 'Не знам какво да ти кажа...';

        $workDir = $this->mainDir . '/python/chatterbot';

        $process = new Process([$this->pythonDir, $workDir . '/chat.py']);
        $process->setWorkingDirectory($workDir);
        $process->setInput($this->input);
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
     * Example: {{RobotTalk::makeAction($conversation_id, 'EmotionalStatusExplain')}}
     */
    public static function makeAction($conversationId = false, $action = '')
    {
        $action = 'Actions\\' . $action;

        dd($action);

        if (class_exists($action)) {
            $newAction = new $action();
            $newAction->setCnversationId($conversationId);
            return $newAction->make();
        }

        return "Не знам какво да направя...";
    }

    public static function noResponse($conversationId = false)
    {
        return "Мислих.. но не знам как да ти отговоря...";
    }

    private function parseResponse($text)
    {
        $text = str_replace('__user_name__', 'човеко', $text);
        $text = str_replace('__robot_name__', 'Ванеса', $text);
        $text = str_replace('__robot_action_emotional_status__', 'Днес съм много добре!', $text);
        $text = str_replace('__robot_action_emotional_status_up__', '', $text);
        $text = str_replace('__robot_action_emotional_status_down__', '', $text);
        $text = str_replace('__robot_action_emotional_status_explain__', '', $text);

        return $text;
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
