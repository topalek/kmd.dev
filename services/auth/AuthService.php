<?php
/**
 * Created by Topalek
 * Date: 19.06.2017
 * Time: 15:05
 */

namespace app\services\auth;

/*
 * @var $user app\entities\User;
 */
use app\entities\User;
use app\forms\LoginForm;
use app\common\repositories\UserRepository;
use Yii;

class AuthService
{
	private $users;

	public function __construct()
	{
		$this->users = new UserRepository();
	}

	public function auth(LoginForm $form): User
	{
		$user = $this->users->findByUsernameOrEmail($form->username);
		if (!$user || !$user->isActive() || !$user->validate($form->password)){
			throw new \DomainException('Incorrect username or password');
		}
		return $user;
	}


}