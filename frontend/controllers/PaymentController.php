<?php

namespace frontend\controllers;
use Yii; 
use common\models\DzhPages;
use common\models\DzhCourse;
use common\models\DzhJoincourse;
use yii\web\NotFoundHttpException; 

class PaymentController extends AppController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCourse($id_course)
    {
        if(!$id_course) {
            throw new NotFoundHttpException('Не передан обязательный параметр!!!');
        }

        $payment    = $this->getPaymentPage();
        $course     = $this->getCourseInfo($id_course); 
        $isJoined   = $this->isJoinedUserCourse($id_course);

        $this->setMeta("Оплата курса " . $course['name']);
 
        if(!$isJoined['id']) {
            throw new NotFoundHttpException('Вы не подписаны на такой курс');
        }

        if(!$course) {
            throw new NotFoundHttpException('Не найден такой курс');
        }
        return $this->render('course', compact('payment', 'id_course', 'course'));
    }

    //Проверка подписки пользователя
    private function isJoinedUserCourse($id_course)
    {
        return DzhJoincourse::find()
                ->select(['id'])
                ->where(['id_user' => Yii::$app->user->identity->id])
                ->andWhere(['id_course' => $id_course])
                ->asArray()
                ->one();
    }

    //Получение информации о странице
    private function getPaymentPage()
    {
        return DzhPages::find()->where(['alias' => 'payment'])->asArray()->one();
    }

    //Получение информации о курсе
    private function getCourseInfo($id_course)
    {
        return DzhCourse::find()->select(['name', 'price'])->where(['id' => $id_course])->asArray()->one();
    }
}
