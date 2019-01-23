<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dzh_testanswer".
 *
 * @property integer $id
 * @property string $answer
 * @property string $isCorrect
 * @property integer $id_quest
 *
 * @property DzhTestquest $idQuest
 */
class DzhTestanswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_testanswer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer'], 'required'],
            [['isCorrect', 'what_is_answer'], 'string'],
            [['id_quest'], 'integer'],
            [['answer'], 'string', 'max' => 255],
            [['id_quest'], 'exist', 'skipOnError' => true, 'targetClass' => DzhTestquest::className(), 'targetAttribute' => ['id_quest' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer' => 'Ответ',
            'id_quest' => 'Вопрос',
            'isCorrect' => 'Корректный ответ',
            'what_is_answer' => 'Почему этот ответ правильный?'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuest()
    {
        return $this->hasOne(DzhTestquest::className(), ['id' => 'id_quest']);
    }
}
