<?php

namespace backend\controllers;

use Yii;
use common\models\DzhComments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Constants; 
use yii\filters\AccessControl;

/**
 * CommentsController implements the CRUD actions for DzhComments model.
 */
class CommentsController extends AppController
{
	public function behaviors()
    {
        return [
            'access'    =>  [
                'class' =>  AccessControl::className(),
                'rules' =>  [
                    [ 
                        'allow' => true,
                        'roles' => [Constants::PERMISSION_IS_VIEW_ADMIN],
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
     * Lists all DzhComments models.
     * @return mixed
     */
    public function actionIndex()
    { 
		$model = [];
		if(Yii::$app->user->can('admin'))
			$model = DzhComments::getCommentsAdmin();
		else 
			$model = DzhComments::getCommentsTeacher();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DzhComments model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing DzhComments model.
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
     * Finds the DzhComments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhComments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhComments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
