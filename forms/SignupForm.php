<?php
/**
 * Created by Topalek
 * Date: 17.06.2017
 * Time: 13:05
 */

namespace app\forms;

use yii\base\Model;

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
			[['username'], 'trim'],
			[['username'], 'required', 'message' => 'Имя не может быть пустым'],
			[['username'], 'unique', 'targetClass' => 'app\entities\User', 'message' => 'Это имя уже занято. Укажите другое'],
			[['username'], 'string',
				'min' => 2, 'max' => 255,
				'message' => 'Имя не может быть меньше 2 символов',
				'tooLong' => 'Имя не может быть больше 255 символов.',
				'tooShort' => 'Имя не может быть менее 2-x символов.'
			],

			[['email'], 'trim'],
			[['email'], 'required', 'message' => 'Email не может быть пустым'],
			[['email'], 'email'],
			[['email'], 'string', 'max' => 255],
			[['email'], 'unique', 'targetClass' => 'app\entities\User', 'message' => 'Этот email уже занят. Укажите другой'],
			[['password'], 'required', 'message' => 'Пароль не может быть пустым'],
			[['password'], 'string', 'min' => 4, 'message' => 'Пароль не может быть менее 4 символов'],
		];
	}

	public function attributeLabels()
	{
		return [
			'username' => 'Имя пользователя',
			'email'    => 'Email',
			'password' => 'Пароль',
		];
	}
}
