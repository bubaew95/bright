<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dzh_made".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_course
 * @property integer $id_question
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property DzhCourse $idCourse
 * @property DzhQuestion $idQuestion
 */
class DzhMade extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dzh_made';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_course', 'id_question'], 'required'],
            [['id_user', 'id_course', 'id_question'], 'integer'],
            [['id_course'], 'exist', 'skipOnError' => true, 'targetClass' => DzhCourse::className(), 'targetAttribute' => ['id_course' => 'id']],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => DzhQuestion::className(), 'targetAttribute' => ['id_question' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_course' => 'Id Course',
            'id_question' => 'Id Question',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCourse()
    {
        return $this->hasOne(DzhCourse::className(), ['id' => 'id_course']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuestion()
    {
        return $this->hasOne(DzhQuestion::className(), ['id' => 'id_question']);
    }

    public function saved($id_user, $id_course, $id_question)
    {
        $this->id_user = $id_user;
        $this->id_course = $id_course;
        $this->id_question = $id_question;
        $this->save();
    }

}
