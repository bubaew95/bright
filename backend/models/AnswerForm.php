<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
 

/**
 * Login form
 */
class AnswerForm extends ActiveRecord
{
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
            // username and password are both required
            [['answer', 'id_quest'], 'required'],
            // rememberMe must be a boolean value
            ['id_quest', 'number'],
            ['what_is_answer', 'string'],
            // password is validated by validatePassword()
            ['isCorrect', 'string', 'max' => 1],
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

}
