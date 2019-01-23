<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DzhTestquest */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("CKEDITOR.plugins.addExternal('youtube', '/admin/assets/e9fee459/plugins/youtube/', 'plugin.js');"); 

?>

<div class="dzh-testquest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_course')->hiddenInput(['value'=> \Yii::$app->request->get("id_course"),])->label(false); ?>
    
    <?= $form->field($model, 'id_week')->hiddenInput(['value'=> \Yii::$app->request->get("id_week")])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
