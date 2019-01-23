<?php

namespace backend\controllers;

use Yii;
use common\models\DzhCompleted;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 
use yii\filters\AccessControl;

/**
 * ComplatedController implements the CRUD actions for DzhCompleted model.
 */
class ComplatedController extends AppController
{
	
	public function behaviors()
    {
        return [
            'access'    =>  [
                'class' =>  AccessControl::className(),
                'rules' =>  [
                    [ 
                        'allow' => true,
                        'roles' => ['isEnterAdminka'],
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
     * Lists all DzhCompleted models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = [];
		$idUser = Yii::$app->user->identity->id;
		if(Yii::$app->user->can('admin'))
			$model = DzhCompleted::find();
		else 
			$model =  DzhCompleted::find()->joinWith('course')->where(['dzh_course.id_user' => $idUser]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DzhCompleted model.
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
     * Creates a new DzhCompleted model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DzhCompleted();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DzhCompleted model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionLink($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isAjax){
            $this->layout = false;
        } 

        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            
            $email = !empty($_POST['DzhCompleted']['email']) ? $_POST['DzhCompleted']['email'] : null;
            if($email) {
                
                try {
                    Yii::$app->mailer->compose('sendCertificate', compact('model'))
                        ->setFrom(['bright-school@mail.ru' => Yii::$app->params['siteName']])
                        ->setTo($email)
                        ->setSubject('Поздравляем вы получили сертификат')
                        ->send();
                        
                } catch(\Swift_TransportException $ex) {
                    echo $ex->getMessage(); exit;
                }
                    
            } else {
                Yii::$app->getSession()->setFlash('error', 'E-mail пользователя не найден!');
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DzhCompleted model.
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
     * Finds the DzhCompleted model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhCompleted the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhCompleted::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
