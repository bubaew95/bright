<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DzhTestquest */

$this->title = 'Изменить вопрос';
$this->params['breadcrumbs'][] = [
    'label' => 'Ответы', 
    'url' => [  
        'index', 
        'id' => \Yii::$app->request->get("id_question"),
        'id_course' => \Yii::$app->request->get("id_course"),
        'id_week' => \Yii::$app->request->get("id_week"),  
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-testquest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formanswer', [
        'model' => $model,
    ]) ?>

</div>
