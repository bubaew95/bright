<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-comments-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'id_quest',
                'value' => function ($data) {
                    return '<b>'. $data->quest->question . '</b>';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'id_user',
                'value' => function ($data) {
                    return $data->user->fio;
                }
            ],
            //'text:ntext',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return \Yii::$app->formatter->asDate($data->created_at, 'php:Y-m-d H:i:s');
                }, 
                'filter' => false
            ],
            // 'updated_at',
            // 'id_parent',
            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url,$model,$key) {
                        return Html::a(
                            'Просмотр', 
                            $url . '&id_course='. \Yii::$app->request->get("id_course").'&id_week=' .\Yii::$app->request->get("id_week"),
                            [ 'class' => 'btn btn-warning']
                        );
                    },
                    'delete' => function ($url,$model,$key) {
                        return Html::a( 
                            'Удалить', 
                            $url . '&id_course='. \Yii::$app->request->get("id_course").'&id_week=' .\Yii::$app->request->get("id_week"),
                            [ 'class' => 'btn btn-danger' ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
