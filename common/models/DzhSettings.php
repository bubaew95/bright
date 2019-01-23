<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dzh_settings".
 *
 * @property integer $id
 * @property string $value
 * @property string $option
 */
class DzhSettings extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dzh_settings';
    }

    public function rules()
    {
        return [
            [['value', 'title', 'visible'], 'string'],
            [['key'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'key' => 'Ключ',
            'value' => 'Значение',
            'visible' => 'Видимость'
        ];
    }
}
