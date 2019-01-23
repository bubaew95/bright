<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\DzhWidgets;
use common\models\DzhCourse;

/**
 * Site controller
 */
class CloseController extends Controller
{

    public function actionIndex()
    {
        $this->layout = false;
        $close = explode('|', Yii::$app->setting->get('close_site'));

        return $this->render('index', [
            'model' => $close
        ]);
    }
    
}
