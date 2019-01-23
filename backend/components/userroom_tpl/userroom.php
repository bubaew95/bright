<?php 
use yii\helpers\Url;
?>
<ul class="list-group">
    <li class="list-group-item disabled">
        <a href="<?= Url::to(['userroom/index'])?>">Общая информация</a>
    </li>
    <li class="list-group-item">
        <a href="<?= Url::to(['userroom/security'])?>">Безопасность</a>
    </li>
    <!-- <li class="list-group-item">
        <a href="<?= Url::to(['userroom/notification'])?>">Уведомление</a>
    </li>  -->
</ul>