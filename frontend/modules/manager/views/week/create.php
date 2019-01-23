<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DzhWeek */

$this->title = 'Добавление недели';
$this->params['breadcrumbs'][] = [
    'label' => 'Курс', 
    'url' => [
        '/course/view', 
        'id' => \Yii::$app->request->get("id_course")
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-week-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
