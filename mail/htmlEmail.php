<?php

use yii\helpers\Html;
use app\models\User;

$user = User::findOne([
    'status' => User::STATUS_ACTIVE,
    'email' => $this->email,
]);
 
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

$contactLink = Yii::$app->urlManager->createAbsoluteUrl(['site/contact', 'token' => $user->contact_token]);

?>
 
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>Follow the link below to reset your password:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>

<div class="contact">
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>Follow the link below to reset your password:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>