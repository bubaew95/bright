<?php

namespace app\modules\manager\controllers;

use Yii; 
use common\models\DzhWeek;
use backend\models\DzhWeekSearch; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeekController implements the CRUD actions for DzhWeek model.
 */
class WeekController extends AppController
{
    /**
     * Lists all DzhWeek models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new DzhWeekSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single DzhWeek model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new DzhWeek model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_course = null)
    {
        if(empty($id_course)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $model = new DzhWeek();

        if ($model->load(Yii::$app->request->post()) && $model->saveWeek($id_course)) {
            return $this->redirect(['course/view', 'id' => $id_course]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DzhWeek model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $id_course)
    {
        $model = $this->findModel($id); 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['course/view', 'id' => $id_course]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DzhWeek model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $id_course)
    {
        $delete = $this->findModel($id);//->delete();
        $question = \common\models\DzhQuestion::find()->where(['id_week' => $delete->id])->asArray()->one();
        if(empty($question)) {
            $delete->delete();
            Yii::$app->getSession()->setFlash('success', 'Неделя успешно удалена');
            return $this->redirect(['/course/view', 'id' => $id_course]);
        } else { 
            Yii::$app->getSession()->setFlash('error', 'Нельзя удалить эту неделю. Сначала удалите все вопросы связанные с ней!');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the DzhWeek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhWeek the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhWeek::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
