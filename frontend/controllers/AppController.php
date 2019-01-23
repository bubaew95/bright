<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\Html;

class AppController extends Controller
{

     public function __construct($id, $module, $config = [])
     {  
         parent::__construct($id, $module, $config = []);
         $closeSite = explode('|', Yii::$app->setting->get('close_site'));
         if($closeSite[2] == 1) {
            return $this->redirect('/close');
         } 
     }

    protected function setMeta($title = null, $keywords = null, $description = null) 
    {
        $this->view->title = Yii::$app->params['siteName'] . ' | ' . $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => Html::encode($keywords) ]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => Html::encode($description)]);
    }

    
    
    //Пагинация
    protected function getPagination($query = null)
    {
        $pages = new Pagination([
            'forcePageParam' => false,
            'pageSizeParam' => false,
            'totalCount' => $query->count(), 
            'pageSize' => Yii::$app->params['pageCount']
        ]);
        return $pages;
    }
}