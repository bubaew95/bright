<?php

namespace app\modules\manager;

use Yii;
use yii\filters\AccessControl;

/**
 * manager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\manager\controllers';


    public function behaviors()
    {
        return [
            'access' =>  [
                'class' =>  AccessControl::className(),
                'rules' =>  [
                    [
                        'actions' => ['login', 'error'],
                        'allow' =>  true,
                    ],
                    [
                        //'actions' => ['logout', 'index'],
                        'allow' =>  true,
                        'roles' => ['@'],
                        'matchCallback' =>  function($rule, $action)
                        {
                            if(Yii::$app->user->identity->isTeacher && Yii::$app->user->identity->status == 10) {
                                return Yii::$app->user->identity->isTeacher;
                            }
                            else if(Yii::$app->user->identity->isAdmin) {
                                return Yii::$app->response->redirect(['/admin']); //$this->redirect(['index'])
                            }
                        }
                    ]
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->controllerMap['elfinder'] = [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'roots' => [
                'baseUrl'=>'',
				'basePath'=>'@frontend/web',
                'path' => 'uploads',
                'name' => 'Uploads'
            ],
        ];
        parent::init();
    }
}
