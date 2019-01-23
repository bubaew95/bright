<?php

namespace backend\controllers;

use Yii;
use common\models\DzhChapter;
use backend\models\DzhChapterSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChapterController implements the CRUD actions for DzhChapter model.
 */
class ChapterController extends AppController
{

    /**
     * Lists all DzhChapter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DzhChapterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DzhChapter model.
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
     * Creates a new DzhChapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DzhChapter();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $weeks = \common\models\DzhWeek::find()->asArray()->all();
            return $this->render('create', [
                'model' => $model,
                'weeks' => $weeks
            ]);
        }
    }

    /**
     * Updates an existing DzhChapter model.
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
            $weeks = \common\models\DzhWeek::find()->asArray()->all();
            return $this->render('update', [
                'model' => $model,
                'weeks' => $weeks
            ]);
        }
    }

    /**
     * Deletes an existing DzhChapter model.
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
     * Finds the DzhChapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhChapter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhChapter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
