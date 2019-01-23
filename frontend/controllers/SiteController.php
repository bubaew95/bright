<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\DzhWidgets;
use common\models\DzhCourse;

/**
 * Site controller
 */
class SiteController extends AppController
{
    /**
     * @inheritdoc
     */
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction', 
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    // SiteController.php
    public function beforeAction($action)
    { 
        if ($action->id == 'error') {
            $this->layout = false;
        }
    
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    { 
        $this->setMeta('Главная страница');
        return $this->render('index', [
            'courses' => $this->getCourses(),
            'widgets' => $this->getWidgets(),
        ]);
    }

    private function getWidgets()
    {
        $widgets = $this->getWidgetsAll();
        
        $tree = [];
        foreach($widgets as $key => $widget) {
            if($widget['id_parent'] == 0) {
                $tree[$key] = $widget;
            } else {
                $tree[$widget['id_parent']]['childs'][$widget['id']] = $widget;
            }
        }  
        return $tree;
    }

    private function getWidgetsAll()
    {
        return DzhWidgets::find()
                ->indexBy('id')
                ->where(['visible' => '0'])
                ->asArray()
                ->all();
    }

    //Вывод курсов
    private function getCourses()
    {
        return DzhCourse::find()
                    ->select(['id', 'name', 'alias', 'img', 'created_at', 'description'])
                    ->where(['visible' => '0'])
                    ->asArray()
                    ->limit(3)
                    ->orderBy(['id' => SORT_DESC])
                    ->all();
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    { 
        $hex = array(
            '#F29B34',
            '#A19C69',
            '#3C3741',
            '#25373D',
            '#EB9532',
            '#60646D'
        );
        $letters = "ДЖОХ БУБАЕВ";
        $avatar_example = file_get_contents('./img/avatar.svg');
        $avatar_example = str_replace('USERNAME', $letters, $avatar_example);
        $avatar_example = str_replace('HEX_COLOR', $hex[array_rand($hex, 1)], $avatar_example);

        $gen_avatar = md5($letters).'.svg';

        file_put_contents('./img/'.$gen_avatar, $avatar_example);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
