<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DzhQuestion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Курс', 
    'url' => [
        'course/view', 
        'id' => \Yii::$app->request->get("id_course")
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Вопросы', 
    'url' => [
        'index', 
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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_week',
            'question',
            'answer:ntext',
        ],
    ]) ?>

</div>
