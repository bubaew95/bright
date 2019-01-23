<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\DzhCourse */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Добавить неделю', ['week/create', 'id_course' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?php if($model->moderation && $model->visible) : ?>
            <?= Html::a('Опубликовать', ['course/activate', 'id_course' => $model->id, 'param' => '0'], ['class' => 'btn btn-warning']) ?>
        <?php else : ?>
            <?= Html::a('Убрать публикацию', ['course/activate', 'id_course' => $model->id, 'param' => '1'], ['class' => 'btn btn-info']) ?>
        <?php endif; ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'img',
            'description',
            'keywords',
            'duration',
            'hourse',
            'created_at',
            'updated_at',
            //'text',
        ],
    ]) ?>

    <?php if($model->weeks): ?>
        <?php foreach($model->weeks as $week): ?>
            <div class="col-md-2 col-sm-2">
                <div class="card-body">
                    <h1 class="card-title">
                        <?= Html::a( $week->name, ['question/index', 'id_course' => $model->id, 'id_week' => $week->id])?>
                    </h1>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif; ?>

    <div class="clearfix"></div>

</div>
