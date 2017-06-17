<?php
/**
 * Created by Topalek
 * Date: 17.06.2017
 * Time: 13:05
 */

namespace app\forms;

use yii\base\Model;
use app\entities\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $username;
	public $email;
	public $password;


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['username', 'trim'],
			['username', 'required'],
			['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Это имя уже занято. Вберите другое'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

			['password', 'required'],
			['password', 'string', 'min' => 4],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup()
	{
		if (!$this->validate()) {
			return null;
		}

		$user = new User();
		$user->username = $this->username;
		$user->email = $this->email;
		$user->setPassword($this->password);
		$user->generateAuthKey();

		return $user->save() ? $user : null;
	}
}
