<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dzh_pages".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $alias
 */
class DzhPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'alias'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'alias' => 'Alias',
        ];
    }
}
