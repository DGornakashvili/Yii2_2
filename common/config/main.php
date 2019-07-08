<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'bot' => [
            'class' => SonkoDmitry\Yii\TelegramBot\Component::class,
            'apiToken' => '812389032:AAEGnf1B0RVpZ4wUyVL1201Mgax1NFyDlOk',
        ],
    ],
];
