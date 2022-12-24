<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\common\controllers',
    'homeUrl' => '/api',

    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
        'v2' => [
            'class' => 'api\modules\v2\Module',
        ],
        // ... add new versions here
    ],


    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'baseUrl' => '/api',
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],

        'user' => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession'   => false,
            'loginUrl'        => null,
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

        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules' => [
                // Begin v1 url rules
                'GET  v1/user/test'   => 'v1/user/test',
                'POST v1/user/signup' => 'v1/user/signup',
                'POST v1/user/login'  => 'v1/user/login',

                'POST v1/resume/create'   => 'v1/resume/create',
                'DELETE v1/resume/delete' => 'v1/resume/delete',
                'GET v1/resume/index'     => 'v1/resume/index',

                'POST v1/vacancy/create' => 'v1/vacancy/create',
                'GET v1/vacancy/index'   => 'v1/vacancy/index',
                'GET v1/vacancy/view/<id:\w+>'  => 'v1/vacancy/view',
                'GET v1/vacancy/click/<id:\w+>' => 'v1/vacancy/click',
                'GET v1/vacancy/clicks/' => 'v1/vacancy/clicks',

                'GET v1/vacancy/related' => 'v1/vacancy/related',


                // METHOD VERSION/CONTROLLER/ALIAS => VERSION/CONTROLLER/ACTION

                // ... add other v1 api url rules here
                ['class' => 'yii\rest\UrlRule',
                     'controller' => [
                         'v1/user',
                         'v1/resume',
                        // ... add other controllers here
                    ],
                ],
            ],// End of v1 url rules

        ],
    ],
    'params' => $params,
];
