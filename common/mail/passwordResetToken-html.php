<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['login/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Привет <?= Html::encode($user->username) ?>,</p>

    <p>Для сброса пароля перейдите по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
