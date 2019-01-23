<?php

namespace backend\controllers;

use Yii;
use common\models\DzhCourse;
use backend\models\DzhCourseSearch; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CourseController implements the CRUD actions for DzhCourse model.
 */
class CourseController extends AppController
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
     * Lists all DzhCourse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DzhCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        $model->id_user = Yii::$app->user->identity->getId();
        if ($model->load(Yii::$app->request->post()) && $model->dSave()) {
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

        if ($model->load(Yii::$app->request->post()) && $model->dSave()) {
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
    
    private function TRANSLIT($str){
        // Массив русских и английских сочетаний
        $alpha = array
    	(
    		"а" => "a",
    		"б" => "b",
    		"в" => "v",
    		"г" => "g",
    		"д" => "d",
    		"е" => "e",
    		"э" => "e",
    		"ё" => "yo",
    		"ж" => "zh",
    		"з" => "z",
    		"и" => "i",
    		"й" => "j",
    		"к" => "k",
    		"л" => "l",
    		"м" => "m",
    		"н" => "n",
    		"о" => "o",
    		"п" => "p",
    		"р" => "r",
    		"с" => "s",
    		"т" => "t",
    		"у" => "u",
    		"ф" => "f",
    		"х" => "h",
    		"ц" => "ts",
    		"ч" => "ch",
    		"ш" => "sh",
    		"щ" => "sch",
    		"ь" => "",
    		"ъ" => "",
    		"ы" => "y",
    		"ю" => "yu",
    		"я" => "ya",
    		" " => "-",
    		"." => "",
    		"?" => "",
    		"/" => "",
    		"\\" => "",
    		":" => "",
    		"*" => "",
    		"\"" => "",
    		"<" => "",
    		">" => "",
    		"|" => "",
    		"&" => ""
        );
    	
    	//Переводим в нижний регистр
    	$Lover_text = mb_convert_case($str, MB_CASE_LOWER, "utf-8");
    
        // Заменяем русские буквы на английские
        $EN_name = strtr($Lover_text, $alpha);
    	
    	return $EN_name;
    }
}
