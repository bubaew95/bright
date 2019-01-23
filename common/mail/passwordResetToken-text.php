<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['login/reset-password', 'token' => $user->password_reset_token]);
?>
Привет <?= $user->username ?>,

Для сброса пароля перейдите по ссылке ниже:

<?= $resetLink ?>
