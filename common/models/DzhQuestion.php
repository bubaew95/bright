<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dzh_question".
 *
 * @property integer $id
 * @property integer $id_week
 * @property string $question
 * @property string $answer
 */
class DzhQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_week', 'id_parent', 'id_course', 'position'], 'integer'],
            [['question', 'answer', 'id_week', 'id_parent', 'id_course'], 'required'],
            [['answer', 'audio_file', 'translate'], 'string'],
            [['question', 'translate_name'], 'string', 'max' => 255],
            ['position', 'default', 'value' => 0],
        ];
    }
	
	public function saved()
	{
		if($this->id_parent > 0) {
			$model = static::find()->where(['id_parent' => $this->id])->asArray()->one();
			if($model['id']) { 
				return false;
			}
		}
		return $this->save();
	}

    //Подписанные вопросы
    public function getMades()
    {
        return $this->hasOne(DzhMade::className(), ['id_question' => 'id'])
                ->select(['id'])
                ->where(['id_user' => Yii::$app->user->identity->id]);
    }

    //Подписанные вопросы
    public function getCoursemade()
    {
        return $this->hasOne(DzhMade::className(), ['id_question' => 'id'])->select(['id']);
    }

    public function getWeek()
    {
        return $this->hasOne(DzhWeek::className(), ['id' => 'id_week']);
    }

    public function getWeeks()
    {
        return $this->hasMany(DzhWeek::className(), ['id' => 'id_week']);
    }

    public function getParents()
    {
        return $this->hasOne(DzhQuestion::className(), ['id' => 'id_parent']);
    }

    public function getTests()
    {
        return $this->hasMany(DzhTestquest::className(), ['id' => 'id_course']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_week' => 'Неделя',
            'id_parent' => 'Наследует',
            'question' => 'Название',
            'answer' => 'Текст',
            'translate' => 'Перевод',
            'audio_file' => 'Аудиозапись',
            'translate_name' => 'Перевод названия',
            'position' => 'Позиция'
        ];
    }
}
