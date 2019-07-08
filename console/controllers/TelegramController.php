<?php

namespace console\controllers;

use Yii;
use common\models\Projects;
use common\models\TelegramSubscribe;
use common\models\TelegramOffset;
use SonkoDmitry\Yii\TelegramBot\Component;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;
use yii\console\Controller;

class TelegramController extends Controller
{
    /** @var  Component */
    private $bot;
    private $offset = 0;

    public function init()
    {
        parent::init();
        $this->bot = Yii::$app->bot;
    }

    public function actionIndex()
    {
        $updates = $this->bot->getUpdates($this->getOffset() + 1);
        $updCount = count($updates);
        if($updCount > 0){
            echo "Новых сообщений " . $updCount . PHP_EOL;
            foreach ($updates as $update){
                $this->updateOffset($update);
                $this->processCommand($update->getMessage());
            }
        }else{
            echo "Новых сообщений нет" . PHP_EOL;
        }
    }
    
    private function getOffset()
    {
        $max = TelegramOffset::find()
            ->select('id')
            ->max('id');
        if($max > 0){
            $this->offset = $max;
        }
        return $this->offset;
    }
    
    private function updateOffset(Update $update)
    {
        $model = new TelegramOffset([
            'id' => $update->getUpdateId(),
            'timestamp_offset' => date("Y-m-d H:i:s")
        ]);
        $model->save();
    }

    private function processCommand(Message $message){
        $params = explode(" ",  $message->getText());
        $command = $params[0];
        $response = 'Unknown command';
        switch($command){
            case "/help":
                $response = "Доступные команды: \n";
                $response .= "/help - список комманд\n";
                $response .= "/project_create ##project_name## -создание нового проекта\n";
                $response .= "/task_create ##task_name## ##responcible## ##project## -созданпие таска\n";
                $response .= "/sp_create  - подписка на создание проекты\n";
                break;
            case "/project_create":
                if ($this->addProject($params[1])) {
                    $response = "Проект {$params[1]} создан\n";
                    
                    $this->sendEventNotifications($command, $params[1]);
                }
                break;
            case "/sp_create":
                if ($this->addSubscribe($message, '/project_create')) {
                    $response = "Выподписаны наоповещение о новых проектах: \n";
                }
                break;
        }
        $this->bot->sendMessage($message->getFrom()->getId(), $response);
    }
    
    private function addSubscribe(Message $message, $eventId)
    {
        $model = new TelegramSubscribe([
            'user_id' => $message->getFrom()->getId(),
            'event_id' => $eventId,
        ]);
        
        return $model->save();
    }
    
    private function addProject(string $projectName)
    {
        $model = new Projects(['name' => $projectName]);
        
        return $model->save();
    }
    
    private function sendEventNotifications(string $command, string $projectName)
    {
        $users = TelegramSubscribe::find()
            ->select('user_id')
            ->where(['event_id' => $command])
            ->asArray()
            ->all();
    
        $notification = "Создан новый проект: {$projectName}\n";
        
        foreach ($users as $user) {
            $this->bot->sendMessage($user, $notification);
        }
    }
}