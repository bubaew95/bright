<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DzhTestquest */
$this->title = 'Изменить вопрос: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Курс', 
    'url' => [  
        'course/view', 
        'id' => \Yii::$app->request->get("id_course")
    ]
];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dzh-testquest-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
