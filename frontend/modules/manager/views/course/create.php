<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DzhCourse */

$this->title = 'Создание курса';
$this->params['breadcrumbs'][] = ['label' => 'Все курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-course-create">

    <br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
