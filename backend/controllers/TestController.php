<?php

namespace backend\controllers;

use Yii;
use common\models\DzhTestquest;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\DzhTestanswer;

/**
 * TestController implements the CRUD actions for DzhTestquest model.
 */
class TestController extends AppController
{

    /**
     * Lists all DzhTestquest models.
     * @return mixed
     */
    public function actionIndex($id_course, $id_week)
    {
        if(empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => DzhTestquest::find()->where(['id_course' => $id_course, 'id_week' => $id_week]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DzhTestquest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $id_course, $id_week)
    { 
        if(empty($id) || empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $modelAnswer = new ActiveDataProvider([
            'query' => DzhTestanswer::find()->where(['=', 'id_quest', $id]),
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelAnswer' =>$modelAnswer
        ]);
    }

    /**
     * Creates a new DzhTestquest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_course, $id_week)
    {
        if(empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $model = new DzhTestquest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id_course' => $model->id_course, 'id_week' => $model->id_week]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DzhTestquest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $id_course, $id_week)
    {
        if(empty($id) || empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_course' => $id_course, 'id_week' => $id_week]); 
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Добавление ответов
     */
    public function actionAnswercreate($id_question, $id_course, $id_week)
    {
        if(empty($id_question) || empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $model = new DzhTestanswer();
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['test/view', 'id' => $id_question, 'id_course' => $id_course, 'id_week' => $id_week]); 
        } else {
            return $this->render('answercreate', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAnswerupdate($id, $id_quest, $id_course, $id_week)
    {
        if(empty($id) || empty($id_quest) || empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }
        $model = DzhTestanswer::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['test/view', 'id' => $id_quest, 'id_course' => $id_course, 'id_week' => $id_week]); 
        } else {
            return $this->render('answerupdate', [
                'model' => $model,
            ]);
        }
    }

    public function actionAnswerdelete($id, $id_quest, $id_course, $id_week)
    {
        if(empty($id) || empty($id_quest) || empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }
        DzhTestanswer::findOne($id)->delete();
        
        return $this->redirect(['test/view', 'id' => $id_quest, 'id_course' => $id_course, 'id_week' => $id_week]); 
    }
    /**
     * Конец ответов
     */

    /**
     * Deletes an existing DzhTestquest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the DzhTestquest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhTestquest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhTestquest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
