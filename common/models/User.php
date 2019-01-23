<?php
namespace common\models;
 
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\DzhUserinfo;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_TEACHER = 5;
    const STATUS_ACTIVE = 10;

 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_user';
    }

    public function getUserInfo()
    {
        return $this->hasOne(DzhUserinfo::className(), ['id_user' => 'id']);
    }

    // Other code goes here...
    public function getFullname()
    {
        $profile = DzhUserinfo::find()->where(['id_user' => $this->id])->one();
        if ($profile !==null)
            return $profile->fio;
        return false;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Заказчик',
            'id_course' => 'Курс',
            'price' => 'Оплаченная цена',
            'phone' => 'Номер телефона',
            'total_price' => 'Цена курса',
            'created_at' => 'Дата регистрации',
            'fio' => 'Ф.И.О',
            'updated_at' => 'Дата обновления',
            'birthday' => 'День рождение',
            'ip' => 'Ip адрес',
            'user_agent' => 'Браузер', 
            'count_check_course' => 'Закончил курсов',
            'actived' => 'Активация',
            'isTeacher' => 'Регистрация в качестве'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_TEACHER]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->andWhere(['!=', 'status', 0])->one(); //static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    //Поиск по Email
    public function findByEmail($email) 
    {
        return static::find()->where(['email' => $email])->andWhere(['!=', 'status', 0])->one(); //static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }
	
	public function findByEmailAdmin($email)
	{
		return static::find()->where(['email' => $email])->andWhere(['!=', 'status', 0])->andWhere(['or',['isAdmin' => '1'], ['isTeacher' => '1']])->one();
	}

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
