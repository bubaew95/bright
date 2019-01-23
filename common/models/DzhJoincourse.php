<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\DzhWeek;
use common\models\User;

/**
 * This is the model class for table "dzh_joincourse".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_course
 * @property string $price
 * @property integer $created_at
 * @property integer $update_at
 * @property string $actived
 *
 * @property DzhCourse $idCourse
 */
class DzhJoincourse extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_joincourse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_course'], 'required'],
            [['id_user', 'id_course', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['actived'], 'string'],
            [['id_course'], 'exist', 'skipOnError' => true, 'targetClass' => DzhCourse::className(), 'targetAttribute' => ['id_course' => 'id']],
        
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

    public function saves($id_course)
    {
        $this->id_user = 1;
        $this->id_course = $id_course;
        $this->save();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Артикул',
            'id_user' => 'Заказчик',
            'id_course' => 'Курс',
            'price' => 'Оплаченная цена',
            'total_price' => 'Цена курса',
            'created_at' => 'Дата заказа',
            'update_at' => 'Дата обновления',
            'actived' => 'Активация',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCourse()
    {
        return $this->hasOne(DzhCourse::className(), ['id' => 'id_course'])->select(['id', 'img', 'name', 'created_at', 'alias']);
    }

    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getWeeks()
    {
        return $this->hasMany(DzhWeek::className(), ['id_course' => 'id_course']);
    }
}
