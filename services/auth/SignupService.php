<?php
/**
 * Created by Topalek
 * Date: 26.06.2017
 * Time: 17:12
 */

namespace app\services\auth;


use app\common\repositories\UserRepository;
use app\entities\User;
use app\forms\SignupForm;

class SignupService
{
	private $users;
	private $mailer;

	public function __construct()
	{
		$this->users = new UserRepository();
		$this->mailer = \Yii::$app->mailer;
	}
	public function signup(SignupForm $form): void
	{
		$user = User::create(
			$form->username,
			$form->email,
			$form->password
		);

		$this->users->save($user);

		$sent = $this->mailer->compose(
			['html' => 'confirm-html','text' => 'confirm-text'],
			['user' => $user]
		)
			->setTo($form->email)
			->setSubject('Signup confirm for '.\Yii::$app->name)
			->send();
		if (!$sent){
			throw new \RuntimeException('Email sending error');
		}
	}

	public function confirm($token): void
	{
		if (empty($token)){
			throw new \DomainException('Empty confirm token.');
		}
		$user = $this->users->getByEmailConfirmToken($token);
		$user->confirmSignup();

		$this->users->save($user);
	}
}