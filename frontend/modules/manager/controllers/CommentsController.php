<?php

namespace app\modules\manager\controllers;

use Yii;
use common\models\DzhComments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentsController implements the CRUD actions for DzhComments model.
 */
class CommentsController extends AppController
{

    /**
     * Lists all DzhComments models.
     * @return mixed
     */
    public function actionIndex()
    { 
        $sql  = "SELECT comm.id, comm.id_quest, comm.id_user, comm.created_at, cr.name, comm.text FROM `dzh_comments` comm ";
        $sql .= "INNER JOIN `dzh_question` quest  ON comm.id_quest = quest.id ";
        $sql .= "INNER JOIN `dzh_course` cr  ON quest.id_course = cr.id ";
        $sql .= "where cr.id_user = " . Yii::$app->user->identity->id;
        $comments = DzhComments::findBySql($sql)->with(['quest', 'user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $comments
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
