<?php

namespace common\models;
use yii\db\ActiveRecord;
use Yii;
//use common\models\DzhJoincourse; 
//use common\models\User; 
use himiklab\sitemap\behaviors\SitemapBehavior;
/**
 * This is the model class for table "dzh_course".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $name
 * @property integer $img
 * @property integer $description
 * @property integer $keywords
 * @property integer $duration
 * @property integer $hourse
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $text
 * @property integer $visible
 * @property integer $moderation
 */
class DzhCourse extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'img', 'description', 'duration', 'hourse' ], 'required'],
            [['name', 'img', 'keywords', 'duration', 'text', 'fone'], 'string'],
            [['price', 'id_user'], 'number'],
            [['moderation', 'visible'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 300],
            [['hourse'], 'string', 'max' => 55]
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
            'sitemap' => [
                'class' => SitemapBehavior::className(),
                'scope' => function ($model) {
                    $model->select(['name', 'description', 'created_at', 'id', 'alias']);
                },
                'dataClosure' => function ($model) {
                    return [
                        'loc' => \yii\helpers\Url::to(["/course/". $model->alias. '/' .$model->id], true),
                        'lastmod' => $model->created_at,
                        'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                        'priority' => 0.8
                    ];
                }
            ],
        ];
    }

    public function getIsJoining()
    {
        return $this->hasOne(DzhJoincourse::className(), ['id_course' => 'id'])->where(['id_user' => Yii::$app->user->identity->id]);
    }
    
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    //Связать с неделями
    public function getWeeks()
    {
        return $this->hasMany(DzhWeek::className(), ['id_course' => 'id']);
    }

    //Сохранение в базе
    public function msave($mod, $vis)
    {
        $this->moderation = $mod;
        $this->visible = $vis;
        return $this->save();
    }
    public function dSave()
    {
        $this->moderation = $this->visible == '0' ? '0' : $this->moderation;
        return $this->save();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'img' => 'Изображение',
            'description' => 'Краткое описание',
            'keywords' => 'Ключевые слова',
            'duration' => 'Продолжительность',
            'hourse' => 'Часы',
            'created_at' => 'Время создания',
            'updated_at' => 'Время изменения',
            'text' => 'Полный текст',
            'price' => 'Цена',
            'fone' => 'Фоновое изрбражение',
            'id_user' => 'Основатель курса',
            'visible' => 'Видимость',
            'moderation' => 'Предварительный просмотр'
        ];
    }
}
