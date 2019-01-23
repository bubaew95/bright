<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/animate.css',
        'css/owl.carousel.css',
        'css/owl.theme.css',
        'css/style.css'
    ];
    public $js = [
        'js/jquery-2.1.3.min.js',
        'js/bootstrap.min.js',
        'js/owl.carousel.js',
        'js/jquery.hoverdir.js',
        'js/main.js'
    ];

    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => []
        ];
    }

    public $depends = [
       // 'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
