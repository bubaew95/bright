<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor; 
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\DzhTestquest */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("CKEDITOR.plugins.addExternal('youtube', '/admin/assets/e9fee459/plugins/youtube/', 'plugin.js');"); 
?>

<style>
.viewTextBox {
    display:none;
}
</style>

<div class="dzh-testquest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'answer')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'id_quest')->hiddenInput(['value'=> \Yii::$app->request->get("id_question")])->label(false); ?>

    <?= $form->field($model, 'isCorrect')->dropDownList([0 => 'Неправильный ответ', 1 => 'Правильный ответ']) ?>

    <div class="what_is_answer" style="<?php  if($model->isCorrect == '0' || empty($model->isCorrect)) echo 'display:none'; ?>">
        <?php 
            echo $form->field($model, 'what_is_answer')->widget(CKEditor::className(), [ 
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                    'extraPlugins' => 'youtube', // здесь подключаем плагин
                ])
            ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$js = <<<JS
    $(document).on('change', 'select', function(){
        var value = $(this).val(); 
        console.log(value);
        if(value == 1) {
            $('.what_is_answer').show();
        } else {
            $('.what_is_answer').hide();
        }
    });
JS;
$this->registerJs($js);
?>