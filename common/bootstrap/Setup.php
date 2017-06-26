<?php
namespace common\bootstrap;

use app\services\auth\PasswordResetServiсe;
use app\services\auth\SignupServiсe;
use Yii;
use yii\base\BootstrapInterface;

class Setup implements BootstrapInterface
{
	public function bootstrap($app)
	{
		$container = Yii::$container;

		$container->setSingleton(PasswordResetServiсe::class,[],[
				[$app->params['supportEmail'] => $app->name . ' robot'],
			]);
		$container->setSingleton(SignupServiсe::class,[],[
				[$app->params['supportEmail'] => $app->name . ' robot'],
			]);
	}
}