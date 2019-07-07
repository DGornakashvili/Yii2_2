<?php

namespace console\controllers;

use yii\console\Controller;
use console\components\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class RatchetController extends Controller
{
    public function actionIndex()
    {
        $wSServer = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ), 8080
        );
        
        $wSServer->run();
    }
}