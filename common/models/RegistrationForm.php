<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class RegistrationForm extends Model
{
    public $email;
    public $password;
    public $repassword;
    public $fio;
    public $phone;
    public $isTeacher;
    private $_user;
    /**
     * @inheritdoc
     */
    public function rules()
    { 
        return [
            // username and password are both required
            [['email', 'password', 'repassword', 'fio', 'phone'], 'required'],
            [['email'], 'email'],
            [['email'], 'isEmail'],
            [['isTeacher'], 'number', 'max' => 1],
            [['phone'], 'string', 'max' => 25, 'min' => 10],  
            [['password', 'repassword'], 'validatePassword'], 
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
            'repassword' => 'Подтвердить пароль',
            'fio' => 'Ф.И.О',
            'phone' => 'Телефон',
            'isTeacher' => ''
        ];
    }

    public function registr()
    {
        if ($this->validate()) 
        {
            $user = new User();
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->isTeacher = $this->isTeacher;
            if($user->save()) {
                $userInfo           = new DzhUserinfo();
                $userInfo->id_user  = $user->id;
                $userInfo->fio      = $this->fio;
                $userInfo->phone    = $this->phone;
                $userInfo->ip       = Yii::$app->request->userIP;
                $userInfo->user_agent = $_SERVER['HTTP_USER_AGENT'];

                $exp = explode(' ', $this->fio);
                $img = mb_substr($exp[0], 0, 1, 'utf-8');
                if(isset($exp[1])) {
                    $img .= mb_substr($exp[1], 0, 1, 'utf-8');
                } 
                $userInfo->img = $img;
                $randColor = [
                    '608e18', '336d00', '50911c',
                    '475d79', '7e318d', 'c80672',
                    '9a0454', '5b1a38', 'c8470d',
                    'ff0431', '00c3ae', 'd82728', 
                    'ff901c', '005da8', 'bdf900'
                ];
                $userInfo->color = $randColor[rand(0, 15)];
                if($userInfo->save()) {

                        Yii::$app->mailer->compose('newuser', [
                                'email' => $user->email,
                                'userInfo' => $userInfo,
                            ])
                            ->setTo('bright-school@mail.ru')
                            ->setFrom(['bright-school@mail.ru' => Yii::$app->params['siteName'] . ' робот'])
                            ->setSubject("!На сайте зарегистрировался новый пользователь")
                            //->setTextBody($txt)
                            ->send();

                    return Yii::$app->user->login($this->getUser(), 0);
                } else {
                    $this->addError(null, '');
                    Yii::$app->getSession()->setFlash('error', 'Не удалось зарегистрироваться. Обратитесь к Администратору сайта');
                    $user->delete();
                }
            } 
        }
        
        return false;
    }

    public function isEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user =  User::find()->select(['id'])->where(['email' => $this->email])->one();
            if ($user) {
                $this->addError(null, '');
                Yii::$app->getSession()->setFlash('error', 'Такой E-mail уже занят!');
            }
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {  
        if (!$this->hasErrors()) { 
            if($this->password != $this->repassword) {
                $this->addError(null, '');
                Yii::$app->getSession()->setFlash('error', 'Пароли не совпадают');
            }
        }
    }


    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email); 
        }
        return $this->_user;
    }
}
