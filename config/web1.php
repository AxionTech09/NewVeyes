<?php
use \kartik\datecontrol\Module;
$params = require(__DIR__ . '/params.php');

$config = [

    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timezone' => 'UTC',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'carsinsuranceindia',
        ],
        'urlManager' => [
                'class' => 'yii\web\UrlManager',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                    ['class' => 'yii\rest\UrlRule', 'controller' => 'api/case'],
                ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.zoho.com',
            'username' => 'no.reply@axionpcs.in',
            'password' => '@xionPCS123',
            'port' => '465', 
            'encryption' => 'ssl', 
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        // Append timestamp to the all external files
        'assetManager' => [ 
            'appendTimestamp' => true,
        ],
        'ffmpeg' => [
            'class' => '\rbtphp\ffmpeg\Ffmpeg', 'path' => '/usr/bin/ffmpeg'
        ], 
        'api' => [
            'class' => 'app\components\Api',
        ],
    ],
    'params' => $params,
    'modules' => [
            'gridview' =>  [
                    'class' => '\kartik\grid\Module'
                    // enter optional module parameters below - only if you need to  
                    // use your own export download action or custom translation 
                    // message source
                    // 'downloadAction' => 'gridview/export/download',
                    // 'i18n' => []
            ],
            'datecontrol' => [
                    'class' => 'kartik\datecontrol\Module',

                    // format settings for displaying each date attribute
                     'displaySettings' => [
                        Module::FORMAT_DATE => 'dd-MM-yyyy',
                        Module::FORMAT_TIME => 'hh:mm:ss a',
                        Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm a', 
                    ],

                    // format settings for saving each date attribute (PHP format example)
                    'saveSettings' => [
                        Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                        Module::FORMAT_TIME => 'php:H:i:s',
                        Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
                    ],

                    // automatically use kartik\widgets for each of the above formats
                    'autoWidget' => true,
            ],
            'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'id',
                    'usernameField' => 'email',
                  ],
                /*'searchClass' => 'app\models\Userdata'*/
                ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',    
            ],
            'api' => [
                'basePath' => '@app/modules/api',
                'class' => 'app\modules\api\Module',
            ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'axion-preinspection/fourwheelerqc',
            'axion-preinspection/fourwheelerqcpdf',
            'axion-preinspection/commercialqc',
            'axion-preinspection/fourwheelerqcpdf',
            'axion-preinspection/video-session',
            'axion-preinspection/assign-location',
            'axion-preinspection/image-upload',
            'axion-preinspection/remove-photo',
            'axion-preinspection/image-uploadbrowse',
            'axion-preinspection/remove-photobrowse',
            'axion-preinspection/vehicleqc',
            'axion-preinspection/video-upload',
            'gii/*',
            'api/case/*'
        ]
    ],

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
