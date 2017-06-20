<?php
/**
 * Created by Topalek
 * Date: 19.06.2017
 * Time: 15:05
 */

namespace app\services\auth;


use app\entities\User;
use app\forms\SignupForm;

class SignupServiсe
{
	public function signup(SignupForm $form): User
	{
		if (User::find()->andWhere(['username'=> $form->username])){
			throw new \DomainException('Username is already exists.');
		}
		if (User::find()->andWhere(['email'=> $form->email])){
			throw new \DomainException('Email is already exists.');
		}
		$user = User::create($form->username, $form->email, $form->password);
		if (!$user->save()){
			throw new \RuntimeException('Saving error.');
		}
		return $user;
	}
}