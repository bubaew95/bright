<?php

namespace backend\controllers;

use backend\models\UserSearch;
use Yii;
use common\models\DzhUserinfo;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\Constants;

/**
 * UsersController implements the CRUD actions for DzhUserinfo model.
 */
class UsersController extends AppController
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
     * Lists all DzhUserinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getUsers(),
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
 
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    private function getUsers()
    {
        return User::find()->select(['dzh_user.*', 'dzh_userinfo.fio', 'dzh_userinfo.phone'])
                ->join('INNER JOIN', 'dzh_userinfo','dzh_userinfo.id_user =dzh_user.id')
                ->where(['!=', 'dzh_user.id', 1])
                ->asArray();
    }

    public function actionAccessteacher($id, $status)
    {
        $model = $this->findModel($id);
        $model->status = $status;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Displays a single DzhUserinfo model.
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
     * Deletes an existing DzhUserinfo model.
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
     * Finds the DzhUserinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhUserinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
