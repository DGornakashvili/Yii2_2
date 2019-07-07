<?php

namespace console\components;


use common\models\Comments;
use common\models\User;
use Exception;
use Ratchet\MessageComponentInterface;
use Ratchet\WebSocket\WsConnection;
use yii\helpers\Json;

class Chat implements MessageComponentInterface
{
    private $users = [];
    
    /**
     * @param WsConnection $conn
     */
    function onOpen($conn)
    {
        $query = $conn->httpRequest->getUri()->getQuery();
        $chatId = explode('=', $query)[1];
        
        $this->users[$chatId][$conn->resourceId] = $conn;
        
        echo "conn> {$conn->resourceId} opened!\n";
    }
    
    /**
     * @param WsConnection $conn
     */
    function onClose($conn)
    {
        $query = $conn->httpRequest->getUri()->getQuery();
        $chatId = explode('=', $query)[1];
        
        unset($this->users[$chatId][$conn->resourceId]);
        
        echo "conn> {$conn->resourceId} closed!\n";
    }
    
    /**
     * @param WsConnection $conn
     * @param Exception $e
     */
    function onError($conn, $e)
    {
        echo $e->getMessage() . PHP_EOL;
        $conn->close();
    }
    
    /**
     * @param WsConnection $from
     * @param string $msg
     */
    function onMessage($from, $msg)
    {
        $msg = Json::decode($msg);
        $chatId = $msg['task_id'];
        $message = $msg['comment'];
        
        $model = new Comments();
        
        if ($msg['comment'] !== '') {
            $model->setAttributes($msg);
            $model->save();
        }
        
        echo "{$from->resourceId}> {$message}\n";
        
        $curUser = User::findOne($msg['user_id']);
        
        $data = [
            'user' => $curUser->username,
            'msg' => $message
        ];
        
        /**
         * @var WsConnection $user
         */
        foreach ($this->users[$chatId] as $user) {
            $user->send(Json::encode($data));
        }
    }
}