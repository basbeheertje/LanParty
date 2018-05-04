<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'monitor'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ],
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'layout' => 'main',
            'db' => 'db',
            'ignoreActions' => ['audit/*', 'debug/*'],
            'accessRoles' => ['admin'],
            'compressData' => true,
        ],
        'monitor' => [
            'class' => \zhuravljov\yii\queue\monitor\Module::class,
        ],
        'cron' => [
            'class' => \basbeheertje\yii2\cronmanager\Module::class,
            'methodfolders' => [
                Yii::getAlias('@common/models/'),
                Yii::getAlias('@frontend/models/'),
                Yii::getAlias('@console/controllers/'),
                Yii::getAlias('@frontend/controllers/'),
            ]
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        /*'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['admin/user/login'],
        ],*/
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'enablePrettyUrl' => true,
            'rules' => array(
                '<module:user>/password/activate/<token>' => '<module>/password/activate'
            ),
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/error',
            'site/signup'
        ]
    ],
    'params' => $params,
];
