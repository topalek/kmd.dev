<?php
/**
 * Created by Topalek
 * Date: 19.06.2017
 * Time: 15:05
 */

namespace app\services\auth;


use app\entities\User;
use app\forms\PasswordResetForm;
use SebastianBergmann\GlobalState\RuntimeException;

class PasswordResetServiсe
{
	private $supportEmail;

	//public function __construct($supportEmail)
	//{
	//	$this->supportEmail = $supportEmail;
	//}
	public function request(PasswordResetForm $form): void
	{
		$user = User::findOne([
			'status' => User::STATUS_ACTIVE,
			'email'  => $form->email,
		]);

		if (!$user) {
			throw new \DomainException('Пользователь не найден.');
		}

		$user->requestPasswordReset();

		if (!$user->save()) {
			throw new RuntimeException('Ошибка сохранения.');
		}

		$sent = \Yii::$app->mailer->compose([
			['html'=> 'passwordResetToken-html', 'text'=> 'passwordResetToken-text'],
			['user'=> $user]
		])
			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name. ' robot'])
			->setTo($user->email)
			->setSubject('Password reset for '. \Yii::$app->name)
			->send();
		if (!$sent){
			throw new RuntimeException('Sending error');
		}
	}

	public function validateToken($token): void
	{
		if (empty($token) || !is_string($token)) {
			throw new \DomainException('Токен замены пароля не может быть пустым.');
		}
		if (!User::findByPasswordResetToken($token)) {
			throw new \DomainException('Неверный токен замены пароля.');
		}
	}

	public function reset(string $token, PasswordResetForm $form): void
	{
		$user = User::findByPasswordResetToken($token);
		if (!$user) {
			throw new \DomainException('Пользователь не найден.');
		}
		$user->resetPassword($form->password);
	}
}