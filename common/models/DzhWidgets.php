<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dzh_widgets".
 *
 * @property integer $id
 * @property string $icon
 * @property string $title
 * @property string $text
 * @property string $option
 * @property integer $id_parent
 * @property string $visible
 */
class DzhWidgets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_widgets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text', 'visible'], 'string'],
            [['id_parent'], 'integer'],
            [['icon', 'title'], 'string', 'max' => 255],
            [['option'], 'string', 'max' => 50],
        ];
    }

    public function getParent() 
    {
        return $this->hasOne(DzhWidgets::className(), ['id' => 'id_parent']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icon' => 'Изображение',
            'title' => 'Название',
            'text' => 'Текст',
            'option' => 'Option',
            'id_parent' => 'Родитель',
            'visible' => 'Видимость',
        ];
    }
}
