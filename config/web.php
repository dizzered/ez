<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'ezBuyBack.com',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'nothoughtsnodreamsnowishesnofear',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/system/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            // actual email configuration
            'transport' => [
                'class'    => 'Swift_SmtpTransport',
                'host'     => 'smtp.gmail.com',
                'username' => 'dizzered@gmail.com',
                'password' => 'prophet545',
                'port'     => '587',
                'encryption' => 'tls',
            ],
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<alias:index|business-solutions|contact|how-it-works|faq|privacy-policy|terms-and-conditions|testimonials>' => 'site/<alias>',
                '<alias:login|logout|register|restore-password>' => 'system/<alias>',
                'phones/<phone:\d+>/<carrier:\d+>/<link:[A-Za-z0-9-_.]+>' => 'phone/redirect',
                'phones/<firm:\d+>/<link:[A-Za-z0-9-_.]+>' => 'phone/redirect-firm',
                'phone/<firm:\w+>/<phone:[A-Za-z0-9-_.]+>' => 'phone/details',
                'phone/<firm:\w+>' => 'phone/firm',
                '<alias:search>' => 'phone/<alias>',
                'user/<alias:profile|get-address-form|save-address|delete-address|orders|payments>' => 'user/account/<alias>',
                'user/<alias:order>/<id:\d+>/?' => 'user/account/<alias>',
                'cart/complete/<id:\d+>/?' => 'cart/complete',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ),
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [ 'admin', 'god', 'user']
        ],
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => \app\modules\admin\AdminModule::class,
            // ... other configurations for the module ...
        ],
        'user' => [
            'class' => \app\modules\user\UserModule::class,
            // ... other configurations for the module ...
        ],
        'dynagrid'=> [
            'class'=>'\kartik\dynagrid\Module',
            // other module settings
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
