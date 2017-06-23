<?php
/**
 * Created by Topalek
 * Date: 23.06.2017
 * Time: 15:34
 */

namespace app\common;
use yii\captcha\CaptchaAction;


class NumericCaptcha extends CaptchaAction
{
	protected function generateVerifyCode()
	{
		$length = 5;
		$digits = '0123456789';
		$code = '';
		for ($i = 0; $i<$length;$i++){
			$code .=$digits[mt_rand(0,9)];
		}
		return $code;
	}
}