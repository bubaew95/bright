<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DzhComments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dzh Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dzh-comments-view">

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_quest',
            'id_user',
            'text:ntext',
            'created_at',
            'updated_at',
            'id_parent',
        ],
    ]) ?>

</div>
