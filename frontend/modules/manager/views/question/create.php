<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DzhQuestion */

$this->title = 'Добавить вопросы';
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
<div class="dzh-question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'weeks' => $weeks,
        'parents' => $parents
    ]) ?>

</div>
