<?php
/**
 * Created by Topalek
 * Date: 26.06.2017
 * Time: 14:38
 */

namespace app\common\repositories;


use app\entities\User;
use common\repositories\NotFoundExeption;

class UserRepository
{
	public function getByEmailConfirmToken($token): User
	{
		return $this->getBy(['email_confirm_token'=>$token]);
	}

	public function getByEmail($email): User
	{
		return $this->getBy(['email'=>$email]);
	}

	public function getByPasswordResetToken($token): User
	{
		return $this->getBy(['password_reset_token'=>$token]);
	}

	public function existsByPasswordResetToken(string $token): bool
	{
		return (bool) User::findByPasswordResetToken($token);
	}

	public function save(User $user): void
	{
		if (!$user->save()){
			throw new \RuntimeException('Saving error.');
		}

	}

	public function findByUsernameOrEmail($value)
	{
		return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
	}

	private function getBy(array $condition)
	{
		if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
			throw new NotFoundExeption('User not found');
		}
		return $user;
	}
}