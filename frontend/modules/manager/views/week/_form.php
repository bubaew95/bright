<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DzhWeek */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dzh-week-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'num')->textInput(['maxlength' => true, 'value' => 1]) ?>
    
    <?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> 
        <?php if(!$model->isNewRecord ): ?> 
            <?= Html::a("Удалить", [
                    '/week/delete', 
                    'id' => \Yii::$app->request->get("id"),
                    'id_course' => \Yii::$app->request->get("id_course")
                ], [
                    'class' => 'btn btn-danger',
                    'data-pjax' => '0',
                    'data-method' => 'post',
                ]) 
            ?> 
        <?php endif; ?>

    </div>
    
    <?php ActiveForm::end(); ?>

</div>
