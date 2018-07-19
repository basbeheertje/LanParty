<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'nl-NL',
    'sourceLanguage' => 'en-US',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'LAN Party local APP',
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
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'frontend.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'frontend' => 'frontend.php',
                        'frontend/error' => 'error.php',
                    ],
                ],
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'common' => 'common.php',
                        'common/error' => 'error.php',
                    ],
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
            'as jobMonitor' => \zhuravljov\yii\queue\monitor\JobMonitor::class,
            'as workerMonitor' => \zhuravljov\yii\queue\monitor\WorkerMonitor::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ]
    ],
];
