<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DzhQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы';

$this->params['breadcrumbs'][] = [
    'label' => 'Курс', 
    'url' => [
        '/course/view', 
        'id' => \Yii::$app->request->get("id_course")
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            echo Html::a(
                'Добавить вопрос', 
                ['create', 'id_course' => \Yii::$app->request->get("id_course"), 'id_week' => \Yii::$app->request->get("id_week")], 
                ['class' => 'btn btn-success']
            ) 
        ?>
        <?php
            echo Html::a(
                'Изменить неделю', 
                [
                    '/week/update', 
                    'id' => \Yii::$app->request->get("id_week"),
                    'id_course' => \Yii::$app->request->get("id_course")
                ], 
                ['class' => 'btn btn-primary']
            ) 
        ?>

        <?php
            if(!$tests) :
                echo Html::a(
                    'Добавить тест', 
                    [
                        '/test/create', 
                        'id_week' => \Yii::$app->request->get("id_week"),
                        'id_course' => \Yii::$app->request->get("id_course")
                    ], 
                    ['class' => 'btn btn-primary']
                );
            endif;
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'question',
                'value' => function ($data) {
                    return empty($data->parents->question) ? "<b>".$data->question ."</b>" : "<a>|--- " . $data->parents->question . " >> " . $data->question."</a>";
                },
                'format' => 'html'
            ], 
            //'question',
            //'answer:ntext',
            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{link}  {view}  {update}  {delete}',
                'buttons' => [
                    'link'  => function ($url,$model,$key) {
                        if($model->id_parent) return false;
                        return Html::a(
                            '<i class="fa fa-reply-all" aria-hidden="true" title="Добавить под вопрос"></i>', 
                             '/manager/question/create?id_course='. 
                             \Yii::$app->request->get("id_course").
                             '&id_week=' .\Yii::$app->request->get("id_week").
                             '&id_parent='. $key
                        );
                    },
                    'view' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open" title="Посмотреть содержимое"></span>', 
                            $url . '&id_course='. \Yii::$app->request->get("id_course").'&id_week=' .\Yii::$app->request->get("id_week")
                        );
                    },
                    'update' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil" class="Редактирование"></span>', 
                            $url . '&id_course='. \Yii::$app->request->get("id_course").'&id_week=' .\Yii::$app->request->get("id_week")
                        );
                    }
                ],
            ],
        ],
    ]);?>

    <?php if($tests) : ?>
        <table class="table table-striped table-bordered">
            <tbody>
            <tr data-key="7"> 
                <td>
                    <b>
                        <a href="<?= Url::to(['/manager/test', 'id_course' => \Yii::$app->request->get("id_course"),'id_week' => \Yii::$app->request->get("id_week") ] )?>">
                            Тестирование
                        </a>
                    </b>
                </td>
            </tr>
            </tbody>
        </table>
    <?php endif ?>

</div>
