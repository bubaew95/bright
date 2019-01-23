<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dzh_testquest".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_course
 * @property integer $id_week
 *
 * @property DzhTestanswer[] $dzhTestanswers
 * @property DzhCourse $idCourse
 * @property DzhWeek $idWeek
 */
class DzhTestquest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_testquest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id_course', 'id_week'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_course'], 'exist', 'skipOnError' => true, 'targetClass' => DzhCourse::className(), 'targetAttribute' => ['id_course' => 'id']],
            [['id_week'], 'exist', 'skipOnError' => true, 'targetClass' => DzhWeek::className(), 'targetAttribute' => ['id_week' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'id_course' => 'Курс',
            'id_week' => 'Неделя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDzhTestanswers()
    {
        return $this->hasMany(DzhTestanswer::className(), ['id_quest' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(DzhCourse::className(), ['id' => 'id_course']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeek()
    {
        return $this->hasOne(DzhWeek::className(), ['id' => 'id_week']);
    }
}
