<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'structure'],
    'language'=>'ru-RU',
    'modules'=>[
        'admin'=>[
            'class'=>'mdm\admin\Module',
            'layout' => 'left-menu',
        ],
        'planning' => 'app\modules\planning\Module',
        'structure' => 'app\modules\structure\Module',
    ],
    'aliases'=>[
        '@planning'=>'@app/modules/planning',
        '@structure'=>'@app/modules/structure',
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'q0H2xHXaLOyLQtYygLx-GeLuSfMyHafF',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
        'ldap' => [
            'class'=>'Edvlerblog\Ldap',
            'options'=>[
                'ad_port' => 389,
                'domain_controllers' => array('vlgd61.ru'),
                'account_suffix' => '@vlgd61.ru',
                'base_dn' => 'OU=adm,DC=vlgd61,DC=ru',
                'admin_username' => 'podlasenko',
                'admin_password' => 'GjFyLt-844',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 60,
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'admin/*',
            'site/*', // add or remove allowed actions to this list
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
