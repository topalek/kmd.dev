<?php
/**
 * Created by Topalek
 * Date: 17.06.2017
 * Time: 13:05
 */

namespace app\forms;

use app\entities\User;
use yii\base\Model;

/**
 * Signup form
 */
class PasswordResetRequestForm extends Model
{
	public $email;

	public function rules()
	{
		return [
			[['email'], 'trim'],
			[['email'], 'required'],
			[['email'], 'email'],
			[['email'], 'exist',
				'targetClass' => 'app\entities\User',
				'filter' => ['status'=>User::STATUS_ACTIVE],
				'message' => 'нет пользователя с таким email'],
		];
	}
}
