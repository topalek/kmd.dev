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
class PasswordResetForm extends Model
{
	public $password;

	public function rules()
	{
		return [
			['password', 'required'],
			['password', 'string','min'=>4],
		];
	}
}
