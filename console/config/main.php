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
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => 'console\controllers\MigrateController',
            'configs' => [
                'console/config/main.php',
                'common/config/main.php'
            ],
            'additionalPaths' => [
                //'@vendor/bubasuma/yii2-simplechat/migrations/m151121_105406_user_profile_table.php',
                //'@vendor/bubasuma/yii2-simplechat/migrations/m151121_105406_user_profile_table.php',
                //'@vendor/bubasuma/yii2-simplechat/migrations/m151121_105453_message_table.php',
                '@bedezign/yii2/audit/migrations', //directory
                //'@yii/rbac/migrations', // directory with alias
                //'@yii/web/migrations/m160313_153426_session_init.php', // single file
            ],
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
