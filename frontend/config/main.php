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
        'monitor',
        'logreader'
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
        ],
        'logreader' => [
            'class' => 'zhuravljov\yii\logreader\Module',
            'aliases' => [
                'Frontend Errors' => '@frontend/runtime/logs/app.log',
                'Console Errors' => '@console/runtime/logs/app.log',
            ],
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'game',
                        'torrent',
                        'site',
                        'profile'
                    ],
                    'patterns' => [
                        'PUT,PATCH {id}' => 'update',
                        'DELETE {id}' => 'delete',
                        'GET,HEAD {id}' => 'view',
                        'GET,HEAD {searchparam}' => 'view',
                        'GET,HEAD {startfinish}' => 'view',
                        'GET,HEAD game/{id}' => 'view',
                        'POST' => 'create',
                        'GET,HEAD' => 'index',
                        '{id}' => 'options',
                        '' => 'options'
                    ],
                    'extraPatterns' => [
                        'GET,POST login' => 'login',
                        'POST logout' => 'logout',
                        'GET,HEAD check/{id}' => 'check',
                        'GET index' => 'index',
                        'GET,POST create' => 'create',
                        'GET update/{id}' => 'update',
                        'GET,POST addtorrent/{id}' => 'addtorrent',
                        'GET,POST addkey/{id}' => 'addkey',
                        'GET,POST avatar' => 'avatar',
                        'GET,POST signup' => 'signup'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d[\\d,]*>',
                        '{searchparam}' => '<searchparam:\\w[\\w,]*>',
                        '{startfinish}' => 'startfinish/<startfinish:\\w[\\w,]*>',
                        '{logindetails}' => '<username:\\w[\\w,]*>/<password:\\w[\\w,]*>',
                        '{validate}' => 'validate',
                        '{sync}' => 'sync',
                        '{action}' => '<action:\\d[\\d,]*>',
                    ],
                ],
                '<controller>/<action>' => '<controller:/w+>/<action:/w+>',
                '<controller>/<action>/' => '<controller:/w+>/<action:/w+>',
                '<module:user>/password/activate/<token>' => '<module>/password/activate'
            ),
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/error',
            'site/signup',
            'site/logout'
        ]
    ],
    'params' => $params,
];
