<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
//            'layout' => 'left-menu',
        ]
    ],
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
//    'modules' => [],
    'components' => [
          //语言包配置
        'i18n'=>[
            'translations'=>[
                '*'=>[
                    'class'=>'yii\i18n\PhpMessageSource',
                    'fileMap'=>[
                        'common'=>'common.php',
                    ],
                ],
            ],
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//                ],
//            ],
//        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\Admin::className(),
//            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'on beforeLogin' => function($event) {
                  $user = $event->identity; //这里的就是User Model的实例
                  $user->login_time = time();
                  $user->login_ip = ip2long(Yii::$app->request->userIP);
                  $user->save();

            },
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
//          全局注入
        'allowActions' => [
//            '*',
        'rbac/*',
        'admin/login',
        'admin/logout',
//            'site/*',
//            'admin/*',
//            'some-controller/some-action',
              // The actions listed here will be allowed to everyone including guests.
              // So, 'admin/*' should not appear here in the production, of course.
              // But in the earlier stages of your development, you may probably want to
              // add a lot of actions here until you finally completed setting up rbac,
              // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];
