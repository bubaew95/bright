<?php

namespace app\modules\manager\controllers;

use Yii;
use common\models\DzhCourse; 
use common\models\DzhComments;


/**
 * Default controller for the `manager` module
 */
class DefaultController extends AppController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    { 
        $this->setMeta('Раздел основателя курса');
        return $this->render('index', [
            'countCourse' => $this->getCountCourse(),
            'countComments' => $this->getCountComments()
        ]);
    }

    private function getCountCourse()
    {
        return DzhCourse::find()->where(['id_user' => Yii::$app->user->identity->id])->asArray()->count();
    }

    private function getCountComments()
    {
        $sql  = "SELECT comm.id, comm.id_quest, comm.id_user, comm.created_at, cr.name, comm.text FROM `dzh_comments` comm ";
        $sql .= "INNER JOIN `dzh_question` quest  ON comm.id_quest = quest.id ";
        $sql .= "INNER JOIN `dzh_course` cr  ON quest.id_course = cr.id ";
        $sql .= "where cr.id_user = " . Yii::$app->user->identity->id;
        return DzhComments::findBySql($sql)->asArray()->count();
    }
}
