<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log'
    ],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            //'class' => \yii\console\controllers\MigrateController::class,
            'class' => console\controllers\MigrateController::class,
            'configs' => [
                'common/config/main.php',
                'console/config/main.php',
            ],
            'additionalPaths' => [
                'vendor/yiisoft/yii2/rbac/migrations',
                '@yii/queue/db/migrations',
                'vendor/mdmsoft/yii2-admin/migrations',
                'vendor/bedezign/yii2-audit/src/migrations',
                'vendor/basbeheertje/yii2-cronmanager/src/migrations'
            ]
        ],
        'cron' => [
            'class' => 'basbeheertje\yii2\cronmanager\commands\CronController',
        ]
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
