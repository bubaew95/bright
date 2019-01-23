<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Вопросы тестирования";
$this->params['breadcrumbs'][] = [
    'label' => 'Курс', 
    'url' => [
        '/course/view', 
        'id' => \Yii::$app->request->get("id_course")
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Неделя', 
    'url' => [
        '/question', 
        'id_course' => \Yii::$app->request->get("id_course"), 
        'id_week' => \Yii::$app->request->get("id_week")
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-testquest-index">

    <p>
        <?= Html::a('Добавить вопрос', ['create', 'id_course' => \Yii::$app->request->get("id_course"), 'id_week' => \Yii::$app->request->get("id_week")], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'id_course',
            'id_week', 

            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>', 
                            $url . '&id_course='. \Yii::$app->request->get("id_course").'&id_week=' .\Yii::$app->request->get("id_week")
                        );
                    },
                    'update' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>', 
                            $url . '&id_course='. \Yii::$app->request->get("id_course").'&id_week=' .\Yii::$app->request->get("id_week")
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
