<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DzhCourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Курсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать курс', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'img',
                'value' => function ($data) {
                    return Html::img($data->img, ['width' => 100]);
                },
                'filter' => false,
                'format' => 'html'
            ],
            'name',
            //'description',
            //'keywords',
            // 'duration',
            // 'hourse',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return \Yii::$app->formatter->asDate($data->created_at, 'php:Y-m-d H:i:s');
                },
                'filter' => false
            ],
            //'created_at',
            // 'updated_at',
            // 'text',

            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url,$model,$key) {
                        return Html::a(
                            'Открыть', 
                            $url,
                            [ 'class' => 'btn btn-warning']
                        );
                    },
                    'update' => function ($url,$model,$key) {
                        return Html::a(
                            'Редактировать', 
                            $url,
                            [ 'class' => 'btn btn-primary']
                        );
                    },
                    'delete' => function ($url,$model,$key) {
                        return Html::a( 
                            'Удалить', 
                            $url,
                            [ 'class' => 'btn btn-danger' ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
