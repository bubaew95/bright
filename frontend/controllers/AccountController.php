<?php

namespace frontend\controllers;
use Yii;
use common\models\DzhJoincourse;

class AccountController extends AppController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMycourse()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $query = $this->getCourses();
        $pages = $this->getPagination($query);
        $courses = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('mycourse', compact('courses', 'pages'));
    }

    private function getCourses()
    {
        return DzhJoincourse::find()
                ->where(['id_user' => Yii::$app->user->identity->id])
                ->orderBy(['id' => SORT_DESC]);
    }
}
