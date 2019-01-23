<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DzhQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тестирование';

$this->params['breadcrumbs'][] = [
    'label' => 'Курс', 
    'url' => [
        'course/view', 
        'id' => \Yii::$app->request->get("id_course")
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-question-index">

    <h1><?= Html::encode($this->title) ?></h1>
</div>