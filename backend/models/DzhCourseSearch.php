<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DzhCourse;

/**
 * DzhCourseSearch represents the model behind the search form about `common\models\DzhCourse`.
 */
class DzhCourseSearch extends DzhCourse
{

    public $id_user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'img', 'description', 'keywords', 'duration', 'hourse', 'text'], 'string'],
            [['id_user'], 'safe'],
            [['created_at', 'updated_at'], 'date'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
		$idUser = Yii::$app->user->identity->id;
		
		if(\Yii::$app->user->can('admin'))
			$query = DzhCourse::find()->where(['moderation' => '0']);
		else 
			$query = DzhCourse::find()->where(['id_user' => $idUser]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'img' => $this->img,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'duration' => $this->duration,
            'hourse' => $this->hourse,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'text' => $this->text,
        ]);

        return $dataProvider;
    }
}
