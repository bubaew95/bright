<?php
namespace backend\controllers;

use Yii; 
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends AppController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
	
	public function behaviors()
    {
        return [
            'access'    =>  [
                'class' =>  AccessControl::className(),
                'rules' =>  [
					[
                        'actions' => ['login', 'logout', 'error'],
                        'allow' =>  true,
                    ],
                    [ 
                        'allow' => true,
                        'roles' => ['isEnterAdminka'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
					'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome(); 
        } 

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->Login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function newUser()
    {
        // $model = \common\models\User::find()->where(['username' => 'admin'])->one();
        // if (empty($model)) {
        //     $user = new \common\models\User();
        //     $user->username = 'admin';
        //     $user->email = 'admin@yoursite.ru';
        //     $user->setPassword('admin');
        //     $user->generateAuthKey();
        //     if ($user->save()) {
        //         echo 'good';
        //     }
        // }
		
		//$auth = Yii::$app->authManager;
		/*//$auth->removeAll(); //На всякий случай удаляем старые данные из БД...
        
        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $editor = $auth->createRole('teacher');
        
        // запишем их в БД
        $auth->add($admin);
        $auth->add($editor);
        
        // Создаем разрешения. Например, просмотр админки isEnterAdminka и редактирование новости updateNews
        $isEnterAdminka = $auth->createPermission('isEnterAdminka');
        $isEnterAdminka->description = 'Просмотр админки';
        
        // Запишем эти разрешения в БД
        $auth->add($isEnterAdminka);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $editor);
        
        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $isEnterAdminka);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1); 
        
        // Назначаем роль editor пользователю с ID 2
        $auth->assign($editor, 5);
		*/
		
		/*$editor = $auth->createRole('teacher');
		$isEnterAdminka = $auth->createPermission('isEnterAdminka');
        $isEnterAdminka->description = 'Просмотр админки';
		
		$auth->addChild($editor, $isEnterAdminka);*/
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
