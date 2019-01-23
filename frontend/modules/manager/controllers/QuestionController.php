<?php

namespace app\modules\manager\controllers;

use Yii;
use common\models\DzhQuestion; 
use common\models\DzhTestquest;
use backend\models\DzhQuestionSearch; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionController implements the CRUD actions for DzhQuestion model.
 */
class QuestionController extends AppController
{

    public function actionExamine($id_course)
    {
        return $this->render('examine');
    }

    /**
     * Lists all DzhQuestion models.
     * @return mixed
     */
    public function actionIndex($id_week, $id_course)
    {
        if(empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $tests = DzhTestquest::find()->asArray()->where(['id_course' => $id_course, 'id_week' => $id_week])->one();
        
        $query = DzhQuestion::find()->where(['id_week' => $id_week]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tests' => $tests
        ]);
    }

    /**
     * Displays a single DzhQuestion model.
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
     * Creates a new DzhQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_course, $id_week)
    {
        $model = new DzhQuestion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/question', 'id_course' => $id_course, 'id_week' => $id_week]); //$this->redirect(['view', 'id' => $model->id]);
        } else {
            $weeks = \common\models\DzhWeek::find()->where(['id_course' => $id_course])->asArray()->all();
            return $this->render('create', [
                'model' => $model,
                'weeks' => $weeks,
                'parents' => $model->find()->where(['id_parent' => 0, 'id_week' => $id_week])->asArray()->all()
            ]);
        }
    }

    /**
     * Updates an existing DzhQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $id_course, $id_week)
    {
        if(empty($id_course) || empty($id_week)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if(!$model->saved()) {
				Yii::$app->getSession()->setFlash('error', 'У этого вопроса есть дочерние вопросы!');
				return $this->redirect(Yii::$app->request->referrer);
			}
            return $this->redirect(['question/index', 'id_course' => $id_course, 'id_week' => $id_week]);
        } else {
            $weeks = \common\models\DzhWeek::find()->where(['id_course' => $id_course])->asArray()->all();
            return $this->render('create', [
                'model' => $model,
                'weeks' => $weeks,
                'parents' => $model->find()->where(['id_parent' => 0, 'id_week' => $model->id_week])->andWhere(['!=', 'id', $id])->asArray()->all()
            ]);
        }
    }

    /**
     * Deletes an existing DzhQuestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $delete = $this->findModel($id);//->delete();
        $child = DzhQuestion::find()->where(['id_parent' => $delete->id])->one();
        if(empty($child)) {
            $delete->delete();
            Yii::$app->getSession()->setFlash('success', 'Запись успешно удалена');
        } else {
            Yii::$app->getSession()->setFlash('error', 'У этой записи есть потомки, ее нельзя удалить!!');
        }
        return $this->redirect(Yii::$app->request->referrer); //$this->redirect(['index']);
    }

    /**
     * Finds the DzhQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DzhQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DzhQuestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
