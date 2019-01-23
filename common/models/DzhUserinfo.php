<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "dzh_userinfo".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $fio
 * @property string $birthday
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $count_check_course
 * @property integer $ip
 * @property string $user_agent
 * @property string $visible
 */
class DzhUserinfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_userinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'fio'], 'required'], 
            [['img'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 16],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id Пользователя',
            'fio' => 'Ф.И.О',
            'birthday' => 'День рождение',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата изменения',
            'count_check_course' => 'Количество законченных курсов',
            'ip' => 'Ip',
            'user_agent' => 'User Agent',
            'visible' => 'Видимость',
        ];
    }
}
