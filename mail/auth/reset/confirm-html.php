<?php
/**
 * Created by Topalek
 * Date: 26.06.2017
 * Time: 10:48
 *
 * @var $this yii\web\View
 * @var $user app\entities\User
 */
use yii\helpers\Html;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
	<p>Hello <?= Html::encode($user->username)?>,</p>
	<p>Follow the link below to confirm your email:</p>
	<p><?= Html::a(Html::encode($confirmLink),$confirmLink)?></p>
</div>
