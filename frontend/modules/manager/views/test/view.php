<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\DzhQuestion */

$this->title = $model->name;
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
<div class="dzh-question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', [
                'update', 
                'id' => $model->id, 
                'id_course' => \Yii::$app->request->get("id_course"), 
                'id_week' => \Yii::$app->request->get("id_week")
            ], 
            ['class' => 'btn btn-primary']) 
        ?>

        <?= Html::a(
            'Добавить ответ', 
            [
                'answercreate',
                'id_question' => \Yii::$app->request->get("id"),
                'id_course' => \Yii::$app->request->get("id_course"), 
                'id_week' => \Yii::$app->request->get("id_week")
            ], 
            ['class' => 'btn btn-success']
        )?>
   
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'id_course',
                'value' => Html::a($model->course->name, ['course/view', 'id' => $model->course->id]),
                'format' => 'html'
            ],
            [
                'attribute' => 'id_week',
                'value' => Html::a($model->week->name, ['course/view', 'id_course' => $model->course->id,'id_week' => $model->week->id]),
                'format' => 'html'
            ],
        ],
    ]) ?>
    
    <br>

    <?= GridView::widget([
        'dataProvider' => $modelAnswer,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'answer',
            //'id_quest',
            [
                'attribute' => 'isCorrect',
                'value' => function ($data) {
                    return $data->isCorrect ? '<span class="text-success">Правильный ответ</span>' : '<span class="text-danger">Неправильный</span>';
                },
                'format' => 'html'
            ],
            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url,$model,$key) {
                        return '<a href="'.Url::to([
                            '/test/answerupdate', 
                            'id' => $key,
                            'id_quest' => \Yii::$app->request->get("id"),
                            'id_course' => \Yii::$app->request->get("id_course"), 
                            'id_week' => \Yii::$app->request->get("id_week")
                        ]).'"><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                    'delete' => function ($url,$model,$key) { 
                        return '<a href="'.Url::to([
                            '/test/answerdelete', 
                            'id' => $key,
                            'id_quest' => \Yii::$app->request->get("id"),
                            'id_course' => \Yii::$app->request->get("id_course"), 
                            'id_week' => \Yii::$app->request->get("id_week")
                        ]).'"><span class="glyphicon glyphicon-trash"></span></a>';
                    }
                ],
            ],
        ],
    ]); ?>

</div>
