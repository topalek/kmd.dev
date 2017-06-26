<?php
/**
 * Created by Topalek
 * Date: 26.06.2017
 * Time: 16:40
 */

namespace app\services\auth;


use app\common\repositories\UserRepository;
use app\forms\PasswordResetRequestForm;

class PasswordResetService
{
	private $mailer;
	private $users;

	public function __construct()
	{
		$this->users = new UserRepository();
		$this->mailer = \Yii::$app->mailer;
	}

	public function request(PasswordResetRequestForm $form): void
	{
		$user = $this->users->getByEmail($form->email);

		if (!$user->isActive()) {
			throw new \DomainException('User is not active.');
		}
		$user->requestPasswordReset();
		$this->users->save($user);


		$sent = $this->mailer->compose([
			['html' => 'confirm-html', 'text' => 'confirm-text'],
			['user' => $user]
		])
			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
			->setTo($user->email)
			->setSubject('Password reset for ' . \Yii::$app->name)
			->send();
		if (!$sent) {
			throw new \RuntimeException('Sending error');
		}
	}

	public function validateToken($token): void
	{
		if (empty($token) || !is_string($token)) {
			throw new \DomainException('Токен замены пароля не может быть пустым.');
		}
		if (!$this->users->existsByPasswordResetToken($token)) {
			throw new \DomainException('Неверный токен замены пароля.');
		}
	}

	public function reset(string $token, PasswordResetRequestForm $form): void
	{
		$user = $this->users->getByPasswordResetToken($token);
		$user->resetPassword($form->password);
		$this->users->save($user);
	}
}