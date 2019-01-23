<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DzhTestquest */

$this->title = 'Добавить вопрос';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-testquest-create">

 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
