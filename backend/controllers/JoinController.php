<?php

namespace backend\controllers;

use Yii;
use common\models\DzhJoincourse;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\Constants;

/**
 * JoinController implements the CRUD actions for DzhJoincourse model.
 */
class JoinController extends AppController
{

	public function behaviors()
    {
        return [
            'access'    =>  [
                'class' =>  AccessControl::className(),
                'rules' =>  [
                    [ 
                        'allow' => true,
                        'roles' => [Constants::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DzhJoincourse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DzhJoincourse::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DzhJoincourse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    } 

    public function actionActivate($isactive, $id)
    {
        if(empty($id)) {
            exit('Не передан обязательный параметр!');
        }

        //$join = new DzhJoincourse();
        $join = DzhJoincourse::findOne($id);
        $join->actived = $isactive;
        $json = [
            'answer' => "Ошибка сервера",
            'code' => 404
        ]; 
        if($join->save()) {
            $is = $isactive ? 0 : 1;
            $json = [
                'answer' => "Активация успешно изменена",
                'code' => 200,
                'url' => '/admin/join/activate?isactive='. $is ."&id={$id}",
                'textBnt' => $isactive ? 'Убрать активацию' : 'Активировать'
            ];
        } 
        echo json_encode($json);
        exit;
    }

    /**
     * Deletes an existing DzhJoincourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DzhJoincourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhJoincourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhJoincourse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
