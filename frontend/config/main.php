<?php

use himiklab\sitemap\behaviors\SitemapBehavior;
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
    'language' => 'ru_RU',
    'charset' => 'utf-8',
    'components' => [
        'setting' => [
            'class' => 'aquy\setting\Setting'
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
			'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['/login']
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false, 
            'rules' => [
                '' => 'site/index',       
                'course/<alias:[0-9a-zA-Z_-]+>/<id>' => 'course/view',
                'course/todo/<alias:[0-9a-zA-Z_-]+>/<id_course>/<id_week>' => 'course/todo',
                'course/todo/<alias:[0-9a-zA-Z_-]+>/<id_course>' => 'course/todo',
                'course/steps/<alias:[0-9a-zA-Z_-]+>/<id_course>/<id_question>' => 'course/steps',
                'course/examine/<alias:[0-9a-zA-Z_-]+>/<id_course>/<id_examine>' => 'course/examine',
                'course/progress/<alias:[0-9a-zA-Z_-]+>/<id_course>' => 'course/progress',
                'page/<page:[0-9a-zA-Z_-]+>' => 'page/index',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                ['pattern' => 'sitemap', 'route' => 'sitemap', 'suffix' => '.xml'],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                // 'yii\web\JqueryAsset' => [
                //     'js'=>[]
                // ],
                // 'yii\bootstrap\BootstrapPluginAsset' => [
                //     'js'=>[]
                // ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ]
        ],
    ], 
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'baseUrl'=>'',
                'basePath'=>'@frontend/web',
                'path' => 'uploads/founder',
                'name' => 'Founder'
            ],
        ]
    ],
    'params' => $params,
    'modules' => [
        'sitemap' => [
            'class' => 'himiklab\sitemap\Sitemap',
            'models' => [
                // your models
                'common\models\DzhCourse', 
                // or configuration for creating a behavior 
            ],
            'urls'=> [
                // your additional urls
                [
                    'loc' => '/',
                    'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority' => 0.9, 
                    'images' => [
                        [
                            'loc'           => '/img/logo.png',
                            'caption'       => 'Изучайте английский язык онлайн с удовольствием.
                                                Онлайн английский нового поколения. 
                                                Интерактивный курс для самостоятельного обучения',
                            'geo_location'  => 'Грозный, Чеченская республика',
                            'title'         => $params['siteName'], 
                        ],
                    ],
                ],
            ],
            'enableGzip' => true, // default is false
            'cacheExpire' => 1, // 1 second. Default is 24 hours
        ],
    ],
];