<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model common\models\DzhQuestion */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("CKEDITOR.plugins.addExternal('youtube', '/admin/assets/e9fee459/plugins/youtube/', 'plugin.js');"); 
?>

<style>
    #addTranslate {
        cursor:pointer;
    }
    .no-visible {
        display:none;
    }
    .visible {
        display:block;
    }
</style>

<div class="container-question">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
    
            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
            
                <?= $form->field($model, 'question')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'id_course')->hiddenInput(['value'=> \Yii::$app->request->get("id_course")])->label(false) ?>
            
                <?php 
                
                    echo $form->field($model, 'answer')->widget(CKEditor::className(), [
                        
                        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[ 
                            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                            'extraPlugins' => 'youtube,', // здесь подключаем плагинconfig.extraPlugins = 'html5audio';
                        ]),
                        
                    ]);
            
                ?> 
                
                <a id="addTranslate" data-param="<?= $model->translate_name ? 1 : 0 ?>"><?= $model->translate_name ? 'Скрыть поля перевода' : 'Добавить перевод' ?></a>
                <div class="translater <?= $model->translate_name ? 'visible' : 'no-visible' ?> ">
                    <?= $form->field($model, 'translate_name')->textInput(['maxlength' => true]) ?>
                
                    <?php 
                        echo $form->field($model, 'translate')->widget(CKEditor::className(), [
                            
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder',[ 
                                'preset' => 'standard', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                'inline' => false, //по умолчанию false
                                'extraPlugins' => 'youtube,', // здесь подключаем плагинconfig.extraPlugins = 'html5audio';
                            ]),
                            
                        ]);
                    ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-4">
                
                <?php 
            
                    echo $form->field($model, 'audio_file')->widget(InputFile::className(), [
                        'language'      => 'ru',
                        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                        'filter'        => 'audio',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'path'          => 'audio',
                        'multiple'      => false       // возможность выбора нескольких файлов
                    ]);
                
                ?>
            
                <div class="form-group field-dzhquestion-id_parent">
                    <label class="control-label" for="dzhquestion-id_parent">Родительская категория (если есть)</label>
                    <select id="dzhquestion-id_parent" class="form-control" name="DzhQuestion[id_parent]">
                        <option value="0">-- Глава --</option>
                        <?php foreach($parents as $parent) : ?>
                            <option value="<?= $parent['id']?>" <?php if(!empty($model) && ($model['id_parent']  == $parent['id'] || \Yii::$app->request->get("id_parent") == $parent['id'])) echo 'selected'; ?>><?= $parent['question']?></option>
                        <?php endforeach; ?>
                    </select>
            
                    <div class="help-block"></div>
                </div>
                
             
                <div class="form-group field-dzhquestion-id_week required has-success">
                    <label class="control-label" for="dzhquestion-id_week">Недели</label>
                    <select id="dzhquestion-id_week" class="form-control" name="DzhQuestion[id_week]" aria-required="true" aria-invalid="false">
                        <option value="0">--Выбрать неделю--</option>
                        <?php foreach($weeks as $week) : ?>
                            <option value="<?= $week['id']?>" <?php if(!empty($model) && ($model['id_week']  == $week['id'] || \Yii::$app->request->get("id_week") == $week['id'])) echo 'selected'; ?>><?= $week['name']?></option>
                        <?php endforeach; ?>
                    </select>
            
                    <div class="help-block"></div>
                </div>
                
                <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
            
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
    
        <?php ActiveForm::end(); ?>
    </div>

</div>

<?php 

$js = <<<JS
    var isOpen = $(this).data('param');
    $('#addTranslate').on('click', function () {
        
        var translater  = $('.translater');
        translater.toggle(500);
        if(!isOpen) {
            $(this).text('Скрыть поля перевода');
        } else {
            isOpen = false;
            $(this).text('Добавить перевод');
        }
        isOpen = !isOpen;
    });
JS;

$this->registerJs($js);
?>
