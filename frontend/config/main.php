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
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => [
                    'class' => \yii\web\JsonParser::class,
                    'asArray' => true,
                ],
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
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
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'caseSensitive' => false,
            // 'enableStrictParsing' => false,
            // 'suffix' => '/',
            // 'normalizer' => [
            //     'class' => 'yii\web\UrlNormalizer',
            //     'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
            // ],
            'rules' => [
                '' => 'site/index',
                'index' => 'site/index',
                'post' => 'post/index',
                'survey' => 'survey/index',
                // 'survey/quiz' => 'survey/quiz',
                'survey/<slug:[\w-]+>' => 'survey/view',
                // 'survey/<slug:[\w-]+>' => 'survey/view',
                // '<url:\w+>' => 'page/index',
                [
                    'class' => 'common\components\PageRule',
                ],
                // '<controller>' => '<controller>/index',
                // '<controller:\w+>' => '<controller>/index',
                // '<controller:\w+>/<id:\d+>' => '<controller>/view',
                // '<controller:\w+>/<slug:[\w-]+>' => '<controller>/view',
                // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                // '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
