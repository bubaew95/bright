<?php

namespace app\modules\manager\controllers;

use Yii; 
use common\models\DzhCourse;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * CourseController implements the CRUD actions for DzhCourse model.
 */
class CourseController extends AppController
{
    
    public function actionActivate($id_course, $param)
    {
        $model = $this->findModel($id_course);
        $model->msave($param, $param);
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    /**
     * Lists all DzhCourse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $course = $this->getLoadCourse();
        $dataProvider = new ActiveDataProvider([
            'query' => $course, 
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        return $this->render('index', [ 
            'dataProvider' => $dataProvider,
        ]);
    }

    private function getLoadCourse()
    {
        return DzhCourse::find()->where(['id_user' => Yii::$app->user->identity->id]);
    }

    /**
     * Displays a single DzhCourse model.
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
     * Creates a new DzhCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DzhCourse();

        if ($model->load(Yii::$app->request->post()) && $model->msave('1', '1')) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DzhCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
 

    public function actionUpdate($id)
    { 
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DzhCourse model.
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
     * Finds the DzhCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhCourse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
