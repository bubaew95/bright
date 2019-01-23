<?php

namespace app\modules\manager\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;

/**
 * Default controller for the `manager` module
 */
class AppController extends Controller
{

    protected function setMeta($title = null, $keywords = null, $description = null) 
    {
        $this->view->title = Yii::$app->params['siteName'] . ' | ' . $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => Html::encode($keywords) ]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => Html::encode($description)]);
    }

}
