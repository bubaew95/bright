<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dzh_week".
 *
 * @property integer $id
 * @property string $name
 *
 * @property DzhChapter[] $dzhChapters
 */
class DzhWeek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_week';
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasOne(DzhChapter::className(), ['id' => 'id_course']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'num'], 'required'],
            [['num'], 'number'],
            [['text'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 150],
        ];
    }

    public function saveWeek($id_course)
    {
        $this->id_course = $id_course;
        return $this->save();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название недели',
        ];
    }
}
