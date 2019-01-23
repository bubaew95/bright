<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetNew extends AssetBundle
{
    public $basePath = '@webroot'; 
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/style.css',
        'css/font-awesome.min.css',
        'css/ionicons.min.css',
    ];
    public $js = [
        // 'js/jquery.js',
        // 'js/bootstrap.min.js',
        //'js/autosize.min.js'
        //'js/small-business.min.js',
    ];

    public $jsOptions = [
        //'position' => \yii\web\View::POS_HEAD
    ];
    
    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => [],
            'js' => []
        ];
    }

    public $depends = [
       // 'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
