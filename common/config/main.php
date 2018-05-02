<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => require(dirname(__FILE__) . '/database.php'),
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            //'useFileTransport' => true,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:401',
                        'yii\web\HttpException:404',
                        'GuzzleHttp\Exception\ConnectException'
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'categories' => [
                        'yii\web\HttpException:401',
                    ],
                    'logFile' => '@runtime/logs/unauthorized.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 2,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'categories' => [
                        'yii\web\HttpException:404',
                    ],
                    'logFile' => '@runtime/logs/notfound.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 2,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'categories' => [
                        'GuzzleHttp\Exception\ConnectException',
                    ],
                    'logFile' => '@runtime/logs/guzzle.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 2,
                ]
            ],
        ],
        'queue' => [
            'class' => \common\components\Queue::class,
            'ttr' => 120,
            'attempts' => 5,
            'db' => 'db',
            'mutex' => \yii\mutex\MysqlMutex::class,
            'on afterError' => ['self', 'onAfterError'],
        ],
    ],
];
