<?php
namespace App\Robot;

use App\Models\RobotIntentTopic;
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
        $workDir = $this->mainDir . '/python/dialog_nltk';

        $getRobotIntentTopics = RobotIntentTopic::all();
        foreach ($getRobotIntentTopics as $getRobotIntentTopic) {

            $topicFolder = $this->mainDir . '/python/dialog_nltk/topics/'.$getRobotIntentTopic->slug();

            $process = new Process([$this->pythonDir, $workDir . '/chat-input.py', $topicFolder]);
            $process->setWorkingDirectory($workDir);
            $process->setInput($this->input);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $robotResponse = $process->getOutput();
            if (strpos($robotResponse, '__robot_action_no_response__') !== false) {
                continue;
            }

            dump([$getRobotIntentTopic->name,$this->input, $robotResponse]);
        }

      //  return $this->parseResponse($robotResponse);
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
