<?php

use kartik\mpdf\Pdf;

$params = require(__DIR__ . '/params.php');

\Yii::setAlias("@root_path", dirname($_SERVER["SCRIPT_FILENAME"]));
\Yii::setAlias("@root_url", dirname($_SERVER["SCRIPT_NAME"]));
Yii::setAlias('@word_output','@root_path/uploads/output');
Yii::setAlias('@word_template','@root_path/uploads/template');
Yii::setAlias('@word_output_url', '@root_url/uploads/output');

$config = [
    'id' => 'basic',
    'name'=>'Base Yii2',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'Asia/Jakarta',
    'bootstrap' => ['log'],
    'components' => [
        'pdf' => [
            'class' => Pdf::class,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'secret',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'basePath'       => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap'        => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
             'class' => 'yii\swiftmailer\Mailer',
             'useFileTransport' => false,
             'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => 'smtp.gmail.com',
                    'username' => 'mkhamimjazuli@gmail.com',
                    'password' => 'lkeobdrkzbfpvnku',
                    'port' => '587',
                    'encryption' => 'tls'
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
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        /*
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
        */
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
