<?php
namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\DzhPages;

/**
 * Site controller
 */
class PageController extends AppController
{
 
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($page)
    {   
        $page = $this->findModel($page);
        if(!$page) {
            throw new NotFoundHttpException('Такой страницы не существует');
        }
        return $this->render('index', [
            'model' => $page
        ]);
    }

    private function findModel($alias)
    {
        return DzhPages::find()->where(['alias' => $alias])->one();
    }
    
}
