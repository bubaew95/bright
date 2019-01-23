<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DzhWeek */

$this->title = 'Редактирование недели: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Недели', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="dzh-week-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
