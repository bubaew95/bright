<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
 
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\DzhCourse */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("CKEDITOR.plugins.addExternal('youtube', '/admin/assets/e9fee459/plugins/youtube/', 'plugin.js');"); 
?>

<div class="dzh-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?//= $form->field($model, 'img')->textInput() ?>

    <?php 

        echo $form->field($model, 'img')->widget(InputFile::className(), [
            'language'      => 'ru',
            'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options'       => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'path'          => 'images',
            'multiple'      => false       // возможность выбора нескольких файлов
        ]);
    
    ?>

    <?php
        echo $form->field($model, 'fone')->widget(InputFile::className(), [
            'language'      => 'ru',
            'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
            'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options'       => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'path'          => 'images/fone',
            'multiple'      => false       // возможность выбора нескольких файлов
        ]);
    ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php  
        echo $form->field($model, 'text')->widget(CKEditor::className(), [ 
            'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
                'extraPlugins' => 'youtube', // здесь подключаем плагин
            ]),
        ]); 
    ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'keywords')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'hourse')->textInput() ?>

    <?= $form->field($model, 'id_user')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <?//= $form->field($model, 'text')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
